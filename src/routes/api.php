<?php

use App\Http\Controllers\addons\MercadopagoController;
use App\Http\Controllers\addons\ToyyibpayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\user\UserController;
use App\Http\Controllers\api\SettingsController;
use App\Http\Controllers\api\FAQController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\user\HomeController;
use App\Http\Controllers\api\user\BookingController;
use App\Http\Controllers\api\user\OtherPagesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace'=>'api'],function (){
    Route::post('user/register',[UserController::class,'register']);
    Route::post('user/login',[UserController::class,'login']);
    Route::post('user/forgot-password',[UserController::class,'forgotPassword']);
    Route::post('user/google-auth', [UserController::class,'googleAuthorization']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user/details',[UserController::class,'details']);
        Route::patch('user/update',[UserController::class, 'update']);
        Route::post('user/logout', [UserController::class, 'logout']);
        Route::post('user/change-password', [UserController::class, 'changePassword']);
        Route::post('user/initiate-deletion', [UserController::class, 'initiateDeletion']);
        Route::post('user/confirm-deletion', [UserController::class, 'confirmDeletion'])->name('confirm.delete.user');

        Route::get('faq/', [FAQController::class, 'index']);
        Route::get('privacy-policy/', [SettingsController::class, 'getPrivacyPolicy']);
        Route::get('terms-of-services/', [SettingsController::class, 'getTermsAndConditions']);
        Route::get('categories/', [CategoryController::class, 'index']);

        // Route::post('user/home', [HomeController::class, 'home']);
        // Route::post('user/category', [HomeController::class, 'category']);
        // Route::post('user/categorywise_product', [HomeController::class, 'categorywise_product']);
        // Route::post('user/product_details', [HomeController::class, 'product_details']);
        // Route::post('user/systemaddon', [HomeController::class, 'systemaddon']);

        // Route::post('user/promocode', [BookingController::class, 'promocode']);
        // Route::post('user/payment', [BookingController::class, 'payment']);

        // Route::post('/user/cmspages', [OtherPagesController::class, 'cmspages']);
        // Route::post('/user/contactdata', [OtherPagesController::class, 'contactdata']);
        // Route::post('/user/savecontact', [OtherPagesController::class, 'save_contact']);
        // Route::post('/user/faq', [OtherPagesController::class, 'faq']);
        
        // Route::post('/user/get_charge', [BookingController::class, 'get_charge']);
        // Route::post('/user/get_location', [BookingController::class, 'get_location']);
        
        Route::get('product/list', [ProductController::class, 'list']);
        Route::get('product/search', [ProductController::class, 'search']);
        Route::get('product/favourite', [ProductController::class, 'getFavourite']);
        Route::get('product/viewed', [ProductController::class, 'getViewed']);
        Route::get('product/recommended', [ProductController::class, 'getRecommended']);
        Route::get('product/personal', [ProductController::class, 'getPersonal']);
        Route::post('product/create', [ProductController::class, 'create']);
        Route::post('product/create-lend-request', [ProductController::class, 'createLendRequest']);
        Route::post('product/favourite', [ProductController::class, 'setFavourite']);
        Route::post('product/viewed', [ProductController::class, 'setViewed']);
        Route::patch('product/update', [ProductController::class, 'update']);
        Route::patch('product/deactivate', [ProductController::class, 'deactivatePersonal']);
        Route::patch('product/activate', [ProductController::class, 'activatePersonal']);
        Route::delete('product/favourite', [ProductController::class, 'deleteFavourite']);
        Route::middleware('apikey')->group(function () {
            Route::put('product/accept-lend-request', [ProductController::class, 'acceptLendRequest']);
        });

        // Route::post('/user/apply_coupon', [BookingController::class, 'apply_coupon']);
        // Route::post('/user/booking', [BookingController::class, 'booking']);
        // Route::post('/user/booking_details', [BookingController::class, 'booking_details']);
        
        // Route::post('/user/bookinghistory', [UserController::class, 'orderdetails']);
        // Route::post('/user/status_update', [BookingController::class, 'status_update']);
        // Route::post('/user/reviews', [BookingController::class, 'reviews']);
        // Route::post('/user/mercadorequestapi', [MercadopagoController::class, 'mercadorequestapi']);
        // Route::post('/user/toyyibpayrequestapi', [ToyyibpayController::class, 'toyyibpayrequestapi']);
        // Route::post('/user/bloglist', [HomeController::class, 'bloglist']);

        // Orders Route
        Route::get('orders/mine',[OrderController::class, 'getMyOrders']);
        Route::get('orders/my-products', [OrderController::class, 'getMyProductOrders']);
    });
});