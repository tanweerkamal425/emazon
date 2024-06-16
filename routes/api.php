<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProductColorController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\ProductSizeController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// all protected routes goes here
// Route::middleware('auth:sanctum')->group(function() {

    //product api
    Route::get('/v1/products', [ProductController::class, 'index']);
    Route::post('/v1/products', [ProductController::class, 'store']);
    Route::get('/v1/products/{id}', [ProductController::class, 'show']);
    Route::patch('/v1/products/{id}', [ProductController::class, 'update']);
    Route::delete('/v1/products/{id}', [ProductController::class, 'delete']);
    Route::post("/v1/products/{id}/images", [ProductController::class, "upload"]);
    Route::post('/v1/products/{id}/product-images', [ProductController::class, 'multiImageUpload']);
    Route::post("/v1/products/{id}/color-variants", [ProductController::class, 'colorVariants']);
    Route::post("/v1/products/{id}/size-variants", [ProductController::class, 'sizeVariants']);

    // category api
    Route::get('/v1/categories', [CategoryController::class, 'index']);
    
    Route::get('v1/categories/all', [CategoryController::class, 'allCategories']);
    Route::post('/v1/categories', [CategoryController::class, 'store']);
    Route::post("/v1/categories/{id}/images", [CategoryController::class, "upload"]);
    Route::get('/v1/categories/{id}', [CategoryController::class, 'show']);
    Route::patch('/v1/categories/{id}', [CategoryController::class, 'update']);

    // size api
    Route::get('/v1/sizes', [SizeController::class, 'index']);
    Route::get('/v1/sizes/all', [SizeController::class, 'allSizes']);
    Route::post('/v1/sizes', [SizeController::class, 'store']);
    Route::get('/v1/sizes/{id}', [SizeController::class, 'show']);
    Route::patch('/v1/sizes/{id}', [SizeController::class, 'update']);
    Route::delete('/v1/sizes/{id}', [SizeController::class, 'delete']);

    // color api
    Route::get('/v1/colors', [ColorController::class, 'index']);
    Route::get('/v1/colors/all', [ColorController::class, 'allColors']);
    Route::post('/v1/colors', [ColorController::class, 'store']);
    Route::get('/v1/colors/{id}', [ColorController::class, 'show']);
    Route::patch('/v1/colors/{id}', [ColorController::class, 'update']);
    Route::delete('/v1/colors/{id}', [ColorController::class, 'delete']);

    // product image api
    Route::get('/v1/product-images', [ProductImageController::class, 'index']);
    Route::get('/v1/product-images/{id}/all', [ProductImageController::class, 'allImages']);
    Route::get('/v1/product-images/{id}/latest-image', [ProductImageController::class, 'getLatestImage']);
    Route::post('/v1/product-images', [ProductImageController::class, 'store']);
    Route::post("/v1/procuct-images/{id}/images", [ProductController::class, "upload"]);
    Route::get('/v1/product-images/{id}', [ProductImageController::class, 'show']);
    Route::patch('/v1/product-images/{id}', [ProductImageController::class, 'update']);
    Route::delete('/v1/product-images/{id}', [ProductImageController::class, 'delete']);

    // product color api
    Route::get('/v1/product-colors', [ProductColorController::class, 'index']);
    Route::get('/v1/product-colors/{id}', [ProductColorController::class, 'show']);
    Route::post('/v1/product-colors', [ProductColorController::class, 'store']);
    Route::patch('/v1/product-colors/{id}', [ProductColorController::class, 'update']);

    // product size api
    Route::get('/v1/product-sizes', [ProductSizeController::class, 'index']);
    Route::get('/v1/product-sizes/{id}', [ProductSizeController::class, 'show']);
    Route::post('/v1/product-sizes', [ProductSizeController::class, 'store']);
    Route::patch('/v1/product-sizes/{id}', [ProductSizeController::class, 'update']);

    // order api
    Route::get('/v1/orders', [OrderController::class, 'index']);
    Route::get('/v1/orders/{id}', [OrderController::class, 'show']);
    Route::patch('/v1/orders', [OrderController::class, 'update']);

    Route::post("/v1/payment/store", [PaymentController::class, 'store']);

    // payment api
    Route::get('/v1/payments', [PaymentController::class, 'index']);
    Route::get('/v1/payments/{id}', [PaymentController::class, 'show']);

    // coupon api
    Route::get('/v1/coupons', [CouponController::class, 'index']);
    Route::post('/v1/coupons', [CouponController::class, 'store']);
    Route::get('/v1/coupons/{id}', [CouponController::class, 'show']);
    Route::patch('/v1/coupons/{id}', [CouponController::class, 'update']);
    Route::delete('/v1/coupons/{id}', [CouponController::class, 'delete']);

    // users api
    Route::get('/v1/users', [UserController::class, 'index']);
    Route::get('/v1/users/{id}', [UserController::class, 'show']);

    //dashboard
    Route::get('/v1/dashboard', [DashboardController::class, 'dashboard']);
// });





