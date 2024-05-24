<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('id', 'desc')->take(12)->get();

        return view('home', [
            'products' => $products,
        ]);
    }
}
