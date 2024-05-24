<?php

namespace App\Http\Controllers;

use session;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // private $user_id = 1;

    public function index(Request $request)
    {
        // return view('cart.index');
        // $user = User::find($this->user_id);
        $user = auth()->user();
        $cart = $user->cart()->first();
        $cart_items = [];
        if (is_null($cart)) {
            $cart = Cart::create([
                "user_id" => $user->id,
            ]);
        }

        // $cart = $user->cart();
        // $order = $cart->toOrder();
        // $order->save();

        // 2. Convert cart items into products
        $cart_items = $cart->cartItems()->get();

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

        $coupon_discount = 0;
        if ($cart->coupon_id) {
            $coupon = $cart->coupon()->first();
            $coupon_discount = $sub_total * $coupon->value / 100;
            $discount = round($discount + $coupon_discount);
        }

        $amount = $gross_total - $discount;

        $order = new Order();
        $order->amount = $amount;
        $order->sub_total = $sub_total;
        $order->gross_total = $gross_total;
        $order->discount = $discount;


        return view('cart.index', [
            "cart_items"        => $cart_items,
            "no_of_cart_items"  => $cart_items->count(),
            "order"             => $order,
            "cart"              => $cart,
            "coupon_discount"   => $coupon_discount,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer',
            "size_id"       => "required|integer|exists:sizes,id",
            "color_id"      => "required|integer|exists:colors,id",
            'qty' => 'required|integer|min:1|max:5',
        ]);


        $user = auth()->user();
        $product_id = (int) $validated['product_id'];
        $qty = (int) $validated['qty'];
        if (is_null($product = Product::find($product_id))) {
            // @TODO set session notification
            redirect('/')->with('error', 'Product does not exist');
        }

        // $user = User::find($this->user_id);
        $user = auth()->user();
        // 1. load the cart of the user
        $cart = $user->cart()->first();
        if (is_null($cart)) {
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);
        }

        // 2. add product to cart item
        if (is_null(CartItem::where('product_id', $product_id)
                                ->where('color_id', $validated['color_id'])
                                ->where('size_id', $validated['size_id'])->first()) == false) {
            //redirect with a message that product already exists in cart;

            return redirect('/cart')->with('message', 'Item already in cart');
        }

        $cart_item = CartItem::create([
            'cart_id'       => $cart->id,
            'product_id'    => $product->id,
            "color_id"      => $validated['color_id'],
            "size_id"       => $validated['size_id'],
            'qty'           => $qty,
        ]);


        return redirect('/cart')->with('success', 'Item added to cart successfully');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'cart_item_id'  => 'required|integer',
            'qty'           => 'required|integer|min:1|max:5',
        ]);

        $cart_item_id = (int) $validated['cart_item_id'];
        $qty = (int) $validated['qty'];

        $user = auth()->user();
        if (is_null($user)) {
            return redirect('/login')->with('error', 'You are not logged in');
        }
        // $user = auth()->user();
        // 1. load the cart of the user

        $cart_item = CartItem::where('id', $cart_item_id)->update([
            'qty' => $qty,
        ]);


        return redirect('/cart')->with('success', 'Cart updated successfully');

    }

    public function delete(Request $request, int $id)
    {
        $cart_item = CartItem::where('id', $id)->delete();

        return redirect('/cart')->with('warning', 'Iitem deleted from cart');
    }

    public function applyCoupon(Request $request)
    {
        $validated = $request->validate([
            "coupon" => "required",
        ]);

        $coupon = Coupon::where("coupon", $validated["coupon"])->first();
        if (is_null($coupon)) {
            return redirect()->route("cart.index")->with('error', 'Invalid coupon code');
        }

        // @TODO check for valid couponi

        $user = auth()->user();
        $cart = $user->cart()->first();
        $cart_items = $cart->cartItems()->get();

        if ($cart_items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty');
        }
        $cart->applyCoupon($coupon)->save();

        return redirect()->route('cart.index')->with('success', 'Coupon applied successfully');
    }

    public function removeCoupon(Request $request)
    {
        $user = auth()->user();
        $cart = $user->cart()->first();
        $cart->removeCoupon()->save();

        return redirect()->route('cart.index')->with('warning', 'Coupon removed');
    }
}
