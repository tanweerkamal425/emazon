<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required", "max:32"],
        ]);

        if (Auth::guard('admin')->attempt($credentials) === false) {
            throw ValidationException::withMessages([
                "email" => ["Invalid email or password."]
            ]);
        }

        $admin = Admin::where('email', $request->email)->first();

        return [
            "admin" => $admin,
        ];
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return [
            "msg" => "logout successful",
        ];
    }
}
