<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\LoginOtp;
use Illuminate\Support\Str;
use App\Mail\UserRegistered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($_POST);
        $credentials = $request->validate([
            'first_name' => 'required|min:4|max:32',
            'last_name' => 'required|min:4|max:32',
            'gender' => 'required|in:0,1',
            'phone' => 'required|size:10|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:16|confirmed',
            'password_confirmation' => 'required',
        ]);
        // dd('ok');

        $passwd = $credentials['password'];
        $password = Hash::make($credentials['password']);
        $credentials['password'] = $password;
        $credentials['image_url'] = env("DEFAULT_PRODUCT_IMAGE_URL");
        // dd('ok');
        $user = User::create($credentials);

        //send mail to the registered user
        $otp = random_int(1000, 9999);
        $time = time() + 180;
        $date = date('Y-m-d H:i:s', $time);
        $login_otp = LoginOtp::create([
            'otp'       =>  $otp,
            'user_id'   =>  $user->id,
            'expires_at'    =>  $date,
        ]);
        // dd($login_otp);
        $registration_mail = new UserRegistered($user, $otp);
        Mail::to($user)->send($registration_mail);

        return view('mails.otp', [
            'user'          =>  $user,
            'password'      =>  $passwd,
        ]);


        // if (!Auth::attempt([
        //     'email' => $user->email,
        //     'password'=> $passwd,
        // ])) {
        //     return redirect()->route('auth.login')
        //             ->with("error", "Credential missmatch");
        // }
        // $name = auth()->user()->first_name;

        // return redirect()->route('product.index')->with('success', "Welcome, {$name}");

    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'otp'  =>   'required|size:4',
        ]);

        $id = $request->id;
        $user = User::find($id);
        $otp_from_user = $validated['otp'];
        $str1 = $user->email . $otp_from_user;
        $otp_in_table = LoginOtp::where('user_id', $user->id)->first()->otp;
        $str2 = $user->email . $otp_in_table;
        // dd($str1,$str2);

        if (strcmp($str1, $str2) != 0) {
            return redirect('/auth/verify')->with('error', 'wrong otp');
        }

        if (!Auth::attempt([
            'email' => $user->email,
            'password'=> $request->password,
        ])) {
            return redirect()->route('auth.login')
                    ->with("error", "Credential missmatch");
        }
        $name = $user->fullName();
        $login_otp = LoginOtp::where('user_id', $user->id)->first();
        $login_otp->delete();
        $user->is_active = 1;
        $user->save();

        return redirect()->route('product.index')->with('success', "Welcome, {$name}");


    }
}
