<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//User Api's
Route::post('/signup', [AuthController::class, 'signup']);
Route::put('/user/{id}', [AuthController::class, 'update']);
Route::get('/user/{id}', [AuthController::class, 'show']);
Route::delete('/user/{id}', [AuthController::class, 'destroy']);

Route::post('/login', [AuthController::class, 'login']);

//Payment routes
Route::post('/create-order', [PaymentController::class, 'createOrder']);
Route::post('/capture-payment', [PaymentController::class, 'capturePayment']);

//Products api
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

//Category Api
Route::post('/categories', [CategoryController::class, 'store']);               // Create a new category
Route::get('/categories/{category_code}', [CategoryController::class, 'show']);  // Fetch category by code
Route::put('/categories/{category_code}', [CategoryController::class, 'update']); // Update category by code
Route::delete('/categories/{category_code}', [CategoryController::class, 'destroy']); // Delete category by code

//Admin Api Route
Route::get('/admin', [AdminController::class, 'index']);          // Fetch all admins
Route::get('/admin/{id}', [AdminController::class, 'show']);      // Fetch a specific admin by ID
Route::post('/admin', [AdminController::class, 'store']);         // Store a new admin
Route::put('/admin/{id}', [AdminController::class, 'update']);    // Update an existing admin by ID
Route::delete('/admin/{id}', [AdminController::class, 'destroy']); // Delete an admin by ID

//Cart Api Route
Route::post('/cart/add', [CartController::class, 'addToCart']);
route::get('/cart', [CartController::class, 'fetchCart']);
route::delete('/cart/delete', [CartController::class, 'deleteCartItem']);
