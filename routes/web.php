<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// API Routes
Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, 'SendOTPCode']);
Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);
Route::post('/reset-password', [UserController::class, 'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/logout', [UserController::class, 'UserLogout']);
Route::get('/user-profile', [UserController::class, 'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update', [UserController::class, 'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);

// Pages Routes
Route::get('/userLogin', [UserController::class, 'LoginPage']);
Route::get('/userRegistration', [UserController::class, 'RegistrationPage']);
Route::get('/sendOtp', [UserController::class, 'SendOtpPage']);
Route::get('/verifyOtp', [UserController::class, 'VerifyOtpPage']);
Route::get('/resetPassword', [UserController::class, 'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard', [UserController::class, 'DasboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userProfile', [UserController::class, 'UserProfilePage']);
Route::get('/categoryPage', [CategoryController::class, 'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/productPage', [ProductController::class, 'ProductPage'])->middleware([TokenVerificationMiddleware::class]);

// Category Api
Route::post('/create-category', [CategoryController::class, 'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-category', [CategoryController::class, 'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-category', [CategoryController::class, 'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-category', [CategoryController::class, 'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/category-by-id', [CategoryController::class, 'CategoryById'])->middleware([TokenVerificationMiddleware::class]);

// Customer Api
Route::post('/create-customer', [CustomerController::class, 'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-customer', [CustomerController::class, 'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-customer', [CustomerController::class, 'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-customer', [CustomerController::class, 'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-by-id', [CustomerController::class, 'CustomerById'])->middleware([TokenVerificationMiddleware::class]);


// Product Api
Route::post('/create-product', [ProductController::class, 'CreateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-product', [ProductController::class, 'ProductList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/product-by-id', [ProductController::class, 'ProductById'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-product', [ProductController::class, 'UpdateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-product', [ProductController::class, 'DeleteProduct'])->middleware([TokenVerificationMiddleware::class]);
