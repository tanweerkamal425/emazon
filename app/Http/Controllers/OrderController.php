<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Konekt\PdfInvoice\InvoicePrinter;

class OrderController extends Controller
{
    private $user_id = 1;

    public function store()
    {
        // $user = User::find($this->user_id);
        $user = auth()->user();
        // $user = User::find($user->id);

        // 1. Load user cart
        $cart = $user->cart()->first();
        // dd($cart);

        // 2. Convert cart items into products
        $cart_items = $cart->cartItems()->get();
        if (count($cart_items) == 0) {
            return redirect('/cart')->with('error', 'Cart is empty');
        }
        $order_items = [];
        foreach ($cart_items as $ci) {
            $product = $ci->product()->first();

            // 3. Create order items agains product
            $order_item = new OrderItem();
            $order_item->user_id = $user->id;
            $order_item->product_id = $product->id;
            $order_item->qty = $ci->qty;
            $order_item->price_mp = $product->price_mp * $ci->qty;
            $order_item->price_sp = $product->price_sp * $ci->qty;
            $order_item->discount = $order_item->price_mp - $order_item->price_sp;

            $order_items[] = $order_item;
        }

        // Calculate order summary
        $gross_total = 0;
        $sub_total = 0;
        $amount = 0;
        $discount = 0;
        foreach ($order_items as $oi) {
            $gross_total += $oi->price_mp;
            $sub_total += $oi->price_sp;
            $discount += ($gross_total - $sub_total);
        }

        $amount = $gross_total - $discount;

        // 4. Create order
        $order = Order::create([
            'amount' => $amount,
            'gross_total' => $gross_total,
            'sub_total' => $sub_total,
            'discount' => $discount,
            'user_id' => $user->id,
        ]);

        // 5. Create Razorpay order
        $rzp_key = env('RAZORPAY_APIKEY');
        $rzp_secret = env('RAZORPAY_SECRET');
        $rzp = new Api($rzp_key, $rzp_secret);
        $rzp_order = null;
        try {
            $rzp_order = $rzp->order->create([
                'receipt'          => "{$order->id}",
                'amount'           => $order->amount * 100,
                'currency'         => 'INR',
                'payment_capture'  => 1,
            ]);
        } catch (Exception $e) {
            Log::error("Razorpay order creation failed: {$e->getMessage()}");
            // @TODO Inform the user about the order failure
            // - Undo all db inserts
            dd("ORDER FAILED AT RAZORPAY");
        }

        // @TODO Set rzp order id in orders and save it in db
        $order->rzp_order_id = $rzp_order['id'];
        $order->save();

        // Store order items in DB
        foreach ($order_items as $oi) {
            $oi->order_id = $order->id;
            $oi->save();
        }

        // 6. Respons razorpay order object to user.
        $razorpay_order_id = $rzp_order['id'];
        // 6. Create data structure for checkout.js
        $data = [
            "key"               => env('RAZORPAY_APIKEY'),
            "amount"            => $order->amount,
            "name"              => "Emazon",
            "description"       => "Emazon e-commerce web app",
            "image"             => "/assets/img/logo.png",
            "prefill"           => [
                "name"          => $user->fullName(),
                "email"         => $user->email,
                "contact"       => $user->phone ? $user->phone : "",
            ],
            // "notes"             => [
               //  "address"           => "Hello World",
               //  "merchant_order_id" => "12312321",
            // ],
            "theme"             => [
                "color"         => "#7B5CC8"
            ],
            "order_id"          => $razorpay_order_id,
        ];

        return view('order.payment', [
            "data" => $data,
        ]);
    }

    public function show(Request $request)
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->orderBy('id', 'desc')->all();

        dd($order);

        return view('order.show', [
            'order' => $order,
        ]);
    }

    public function success()
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        return view('order.success', [
            'order' =>  $order,
        ]);
    }

    public function failure()
    {
        return view('order.failure');
    }

    public function downloadInvoice(Request $request, int $id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            abort(404);
        }

        $user = $order->user()->first();
        $order_items = $order->orderItems()->get();

        $invoice = new InvoicePrinter("A4", "₹ ");

        $invoice->addCustomHeader("Emazon", "value");

        // header settings
        $invoice->setLogo(public_path('assets/img/logo.png'));
        $invoice->setColor("#007fff");
        $invoice->setType("Sale Invoice");    // Invoice Type
        $invoice->setReference($order->id);   // Reference
        $invoice->setDate(date('M dS ,Y', strtotime($order->created_at)));   //Billing Date
        $invoice->setTime(date('h:i:s A', strtotime($order->created_at)));   //Billing Time
        $invoice->setFrom(array("Seller Name", "Sample Company Name", "128 AA Juanita Ave","Glendora , CA 91740"));
        $invoice->setTo(array("Purchaser Name", $user->fullName(), "128 AA Juanita Ave","Glendora , CA 91740"));

        foreach ($order_items as $oi) {
            $product = $oi->product()->first();

            $invoice->addItem(
                $product->title,
                $product->description,
                $oi->qty,
                false,
                $oi->price_sp,
                $oi->discount,
                $oi->price_sp * $oi->qty
            );
        }

        $invoice->addTotal("Total", $order->amount);
        $invoice->addBadge("Payment Paid");
        $invoice->addTitle("Important notice");
        $invoice->addParagraph("No item will be replaced or refunded if you do not have the invoice with you");
        $invoice->setFooterNote(env("APP_NAME"));
        $invoice->render("invoice-{$order->id}.pdf","I");
    }
}
