<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Order;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::post('/search', [ProductController::class, 'search_by_name']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart.remove');

    Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply-coupon');
    Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove-coupon');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/auth/logout', LogoutController::class)->name('auth.logout');
    Route::post("/payment/store", [PaymentController::class, 'store']);
    Route::get("/order/success", [OrderController::class, 'success'])->name('order.success');
    Route::get("/order/failure", [OrderController::class, 'failure'])->name('order.failure');
    Route::get("/order/show/", [OrderController::class, 'show'])->name('order.show');

    Route::get('/user/{id}', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{id}/upload', [UserController::class, 'image'])->name('user.image');
    Route::post('/user/{id}/upload', [UserController::class, 'upload'])->name('user.upload');
    Route::get('/user/{id}/profile', [UserController::class, 'profile']);
    Route::get('/user/{id}/account', [UserController::class, 'account']);
    Route::patch('/user/{id}/account', [UserController::class, 'changePassword']);

    Route::get('/order', [UserController::class, 'userOrders']);
    Route::get('/order/{id}', [UserController::class, 'userSingleOrder'])->name('order.show');

    Route::get('/address', [AddressController::class, 'index']);
    Route::get('/address/create', [AddressController::class, 'create']);
    Route::post('/address', [AddressController::class, 'store']);
    Route::get('/address/{id}', [AddressController::class, 'show']);
    Route::get('/address/{id}/edit', [AddressController::class, 'edit']);
    Route::patch('/address/{id}', [AddressController::class, 'update']);




});

Route::get('/auth/login', [LoginController::class, 'index'])->name('auth.login');
Route::post('/auth/authenticate', [LoginController::class, 'authenticate'])->name('auth.authenticate');
Route::get('/auth/register', [RegisterController::class,'index'])->name('auth.register');
Route::post('/auth/register', [RegisterController::class,'store'])->name('auth.store');
Route::post('/auth/verify', [RegisterController::class, 'verify'])->name('auth.verify');

Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout']);






