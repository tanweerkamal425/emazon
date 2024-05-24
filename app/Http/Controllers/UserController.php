<?php

namespace App\Http\Controllers;

use auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $address = $user->address()->first();
        // dd($address);
        return view('user.index', [
            'user'  =>  $user,
            'address'   =>  $address,
        ]);
    }

    public function userOrders()
    {
        $user = auth()->user();
        $orders = $user->orders()->get();
        // dd($orders);
        $order_items = [];
        $products = [];

        foreach($orders as $o) {
            $items = $o->orderItems()->get();
            foreach($items as $i) {
                $order_items[] = $i;
                $products[] = $i->product()->first();
            }
        }



        // dd($order_items);
        return view('user.orders', [
            'orders'    =>  $orders,
            'order_items'   =>  $order_items,
            'products'  =>  $products,
        ]);
    }

    public function userSingleOrder(Request $request, int $id)
    {
        $user = auth()->user();
        $order = Order::find($id);
        $order_items = $order->orderItems()->get();

        // dd($order_items);
        $coupon = $order->coupon()->first();
        // dd($coupon);

        return view('user.order', [
            'user'  =>  $user,
            'order' =>  $order,
            'order_items'   =>  $order_items,
        ]);
    }

    public function account()
    {
        return view('user.account');
    }

    public function changePassword(Request $request)
    {
        $credentials = $request->validate([
            'old_password'  =>  'required|min:6|max:16',
            'new_password' => 'required|min:6|max:16',
            'password_confirmation' => 'required|same:new_password',
        ]);


        $user = auth()->user();
        $password = Hash::make($credentials['new_password']);

        $user->password = $password;
        $user->save();
        // dd('ok');

        return redirect("/user/{$user->id}/profile")->with('success', 'Password changed successfully');
    }
    public function profile()
    {
        $user = auth()->user();
        $address = $user->address()->first();
        // dd($address);

        return view('user.profile', [
            'user'  =>  $user,
            'address'   =>  $address,
        ]);
    }

    public function image()
    {
        return view('user.image');
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'image_url' =>  'required|file|mimes:jpeg,png,jpg|max:1024',
        ]);

        $user = auth()->user();
        // if (is_null($category)) {
        //     throw new NotFoundResourceException("The category with ID '$id' does not exist");
        // }

        $old_image = $user->image_url;
        $validated['image_url'] = $old_image;

        if ($file = $request->file('image_url')) {
            $name = time() . Str::random(10) .'.jpg';
            $file->move('uploads', $name);
            $validated['image_url'] = env('ASSETS_CDN') . $name;
        }

        $user->image_url = $validated['image_url'];
        $user->save();
        // dd('ok');

        if (!is_null($old_image) && $request->hasFile('image_url')) {
            $file_name = strrchr($old_image, "/");
            if ($file_name !== false && !strstr($file_name, "default-image.jpg")) {
                $image_path = public_path('uploads' . $file_name);
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        return redirect("/user/'{$user->id}'/profile")->with('success', "Image uploaded successfully");
    }

}
