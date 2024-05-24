<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required|min:6|max:16",
        ]);

        if (!Auth::attempt($credentials)) {
            return redirect()->route('auth.login')
                    ->with("error", "Credential missmatch");
        }
        $name = auth()->user()->first_name;

        return redirect()->intended('/products')->with('success', "Welcome, {$name}");
    }
}
