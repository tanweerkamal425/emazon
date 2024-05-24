<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        // @TODO Validate
        $validated = $request->validate([
            "razorpay_order_id" => "required|exists:orders,rzp_order_id",
            "razorpay_payment_id" => "required",
            "razorpay_signature" => "required",
        ]);

        $order = Order::findByRazorpayOrderId($validated['razorpay_order_id']);

        $api = new Api(env('RAZORPAY_APIKEY'), env('RAZORPAY_SECRET'));
        $attributes = [];
        try {
            $attributes = $validated;

            $api->utility->verifyPaymentSignature($attributes);
        } catch(SignatureVerificationError $e) {
            // @TODO log the signature varification error
            Log::error("Razorpay payment signature verification failed.: {$e->getMessage()}");
            abort(400);
            // $error = 'Razorpay Error: ' . $e->getMessage();
            // Session::flash('error', 'We are not able to verify your payment!');
            // return redirect('/order/failure');
        }

        $payment = Payment::create([
            'amount' => $order->amount,
            'order_group_id' => ""  . random_int(10000, 999999999),
            'pg_payment_id' => $validated['razorpay_payment_id'],
            'status' => 1,
            'mode' => 1,
            'user_id' => $order->user_id,
        ]);

        // @TODO Update order status to successful.
        $order->status = 1;
        $order->save();

        // Clear the user cart
        $user = User::find($order->user_id);
        $cart = $user->cart()->first();
        $cart->destroyCart();

    }
}
