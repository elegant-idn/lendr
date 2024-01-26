<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\PlanPricingController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\TransactionController;
use App\Http\Controllers\admin\OtherController;
use App\Http\Controllers\admin\FeaturesController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\TestimonialController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\WorkinghoursController;
use App\Http\Controllers\admin\LocationController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\GalleryController;
use App\Http\Controllers\admin\WorksController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\WhyChooseUsController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\SystemAddonsController;
use App\Http\Controllers\admin\BookingsController as VendorBookingController;
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

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
 
    return "Cleared!";
});

Route::get('/admin', [AdminController::class, 'login']);
Route::get('/user/confirm-deletion/{token}', [UserController::class, 'confirm_deletion']);

Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::post('/checklogin', [AdminController::class, 'check_admin_login']);
    // Route::get('/register', [AdminController::class, 'register']);
    // Route::post('/register_vendor', [AdminController::class, 'register_vendor']);
    Route::get('/forgot_password', [AdminController::class, 'forgot_password']);
    Route::post('/send_password', [AdminController::class, 'send_password']);
    // Route::post('/getcity', [AdminController::class, 'getcity']);

    // systemaddons
    // Route::get('systemaddons', [SystemAddonsController::class,'index']);
    // Route::get('createsystem-addons', [SystemAddonsController::class,'createsystemaddons']);
    // Route::post('systemaddons/store', [SystemAddonsController::class,'store']);
    // Route::get('systemaddons/list', [SystemAddonsController::class,'list']);
    // Route::post('systemaddons/update', [SystemAddonsController::class,'update']);

    Route::get(
        '/verification',
        function () {
            return view('admin.auth.verify');
        }
    );
    Route::post('systemverification', [AdminController::class, 'systemverification'])->name('admin.systemverification');
    
    Route::group(['middleware' => 'AuthMiddleware'], function () {
        Route::get('/logout', [AdminController::class, 'logout']);
        Route::get('/dashboard', [AdminController::class, 'index']);
        Route::post('/edit-profile', [AdminController::class, 'edit_profile']);
        Route::post('/change-password', [AdminController::class, 'change_password']);
        
        //setting
        Route::get('/settings', [SettingsController::class, 'index']);
        // Route::post('/add', [SettingsController::class, 'store']);
        Route::post('/og_image', [SettingsController::class, 'save_seo']);
        Route::post('/save_product', [SettingsController::class, 'save_product']);
        // Route::post('/themeupdate', [SettingsController::class, 'themeupdate']);
        // Route::get('settings/delete-feature-{id}', [SettingsController::class, 'delete_feature']);

        // Route::get('/plan', [PlanPricingController::class, 'view_plan']);
        // Route::get('/plan/delete-{id}', [PlanPricingController::class, 'delete']);

        // payment
        Route::group(['prefix' => 'payment'], function () {
            // Route::get('/', [PaymentController::class, 'index']);
            // Route::post('/update', [PaymentController::class, 'update']);
        });

        // transaction
        Route::group(['prefix' => 'transaction'], function () {
            // Route::get('/', [TransactionController::class, 'index']);
        });
        // other pages
        Route::get('/privacypolicy', [OtherController::class, 'privacypolicy']);
        Route::post('/privacypolicy/update', [OtherController::class, 'update_privacypolicy']);
        Route::get('/termscondition', [OtherController::class, 'termscondition']);
        Route::post('/termscondition/update', [OtherController::class, 'update_terms']);
        // Route::get('/aboutus', [OtherController::class, 'aboutus']);
        // Route::post('/aboutus/update', [OtherController::class, 'update_aboutus']);

        // contacts
        // Route::get('/contacts', [OtherController::class, 'index']);
        // Route::get('/contacts/delete-{id}', [OtherController::class, 'delete']);
        // Route::get('/subscribers', [OtherController::class, 'subscribers']);
        // Route::get('/subscribers/delete-{id}', [OtherController::class, 'subscribers_delete']);


        //testimonial
        // Route::get('/testimonials', [TestimonialController::class, 'index']);
        // Route::get('/testimonials/add', [testimonialController::class, 'add']);
        // Route::post('/testimonials/save', [testimonialController::class, 'save']);
        // Route::get('/testimonials/edit-{id}', [testimonialController::class, 'edit']);
        // Route::post('/testimonials/update-{id}', [testimonialController::class, 'update']);
        // Route::get('/testimonials/delete-{id}', [testimonialController::class, 'delete']);
        Route::middleware('AdminMiddleware')->group(function () {
            // Route::get('transaction-{id}-{status}', [TransactionController::class, 'status']);

            // products
            Route::group(['prefix' => 'products'], function () {
                Route::get('/approval', [ProductController::class, 'approval']);
                Route::post('/approval-selected', [ProductController::class, 'approval_selected']);
                Route::get('/delete-{slug}', [ProductController::class, 'delete'])->name('products.delete');
                Route::get('/view/{slug}', [ProductController::class, 'view']);
                Route::get('/status_change-{slug}/{status}', [ProductController::class, 'status_change'])->name('products.status_change');
            });

            //   FAQa
            Route::group(['prefix' => 'faqs'], function () {
                Route::get('/', [OtherController::class, 'faq_index']);
                Route::get('/add', [OtherController::class, 'faq_add']);
                Route::post('/save', [OtherController::class, 'faq_save']);
                Route::get('/edit-{id}', [OtherController::class, 'faq_edit']);
                Route::post('/update-{id}', [OtherController::class, 'faq_update']);
                Route::get('/delete-{id}', [OtherController::class, 'faq_delete']);
                Route::post('/savecontent', [OtherController::class, 'savecontent']);
            });

            // categories
            Route::group(['prefix' => 'categories'], function () {
                Route::get('/', [CategoryController::class, 'view_category']);
                Route::get('/add', [CategoryController::class, 'add_category']);
                Route::post('/save', [CategoryController::class, 'save_category']);
                Route::get('/edit-{slug}', [CategoryController::class, 'edit_category']);
                Route::post('/update-{slug}', [CategoryController::class, 'update_category']);
                Route::get('/change_status-{slug}/{status}', [CategoryController::class, 'change_status']);
                Route::get('/delete-{slug}', [CategoryController::class, 'delete_category']);
            });
            // plan
            // Route::group(['prefix' => 'plan'], function () {
            //     Route::get('/add', [PlanPricingController::class, 'add_plan']);
            //     Route::post('/save_plan', [PlanPricingController::class, 'save_plan']);
            //     Route::get('/edit-{id}', [PlanPricingController::class, 'edit_plan']);
            //     Route::post('/update_plan-{id}', [PlanPricingController::class, 'update_plan']);
            //     Route::get('/status_change-{id}/{status}', [PlanPricingController::class, 'status_change']);
            //     Route::get('/delete-{id}', [PlanPricingController::class, 'delete']);
            // });

            // users
            // Route::group(['prefix' => 'users'], function () {
            //     Route::get('/', [UserController::class, 'view_users']);
            //     Route::get('/add', [UserController::class, 'add']);
            //     Route::get('/edit-{slug}', [UserController::class, 'edit']);
            //     Route::post('/edit_vendorprofile', [UserController::class, 'edit_vendorprofile']);
            //     Route::get('/status-{slug}/{status}', [UserController::class, 'change_status']);
            //     Route::get('/login-{slug}', [UserController::class, 'vendor_login']);
            // });

            // countries
            // Route::group(
            //     ['prefix' => 'countries'],
            //     function () {
            //         Route::get('/', [OtherController::class, 'countries']);
            //         Route::get('/add', [OtherController::class, 'add_country']);
            //         Route::post('/save', [OtherController::class, 'save_country']);
            //         Route::get('/edit-{id}', [OtherController::class, 'edit_country']);
            //         Route::post('/update-{id}', [OtherController::class, 'update_country']);
            //         Route::get('/delete-{id}', [OtherController::class, 'delete_country']);
            //         Route::get('/change_status-{id}/{status}', [OtherController::class, 'statuschange_country']);
            //     }
            // );
            // city
            // Route::group(
            //     ['prefix' => 'cities'],
            //     function () {
            //         Route::get('/', [OtherController::class, 'cities']);
            //         Route::get('/add', [OtherController::class, 'add_city']);
            //         Route::post('/save', [OtherController::class, 'save_city']);
            //         Route::get('/edit-{id}', [OtherController::class, 'edit_city']);
            //         Route::post('/update-{id}', [OtherController::class, 'update_city']);
            //         Route::get('/delete-{id}', [OtherController::class, 'delete_city']);
            //         Route::get('/change_status-{id}/{status}', [OtherController::class, 'statuschange_city']);
            //     }
            // );
            //features
            // Route::get('/features', [FeaturesController::class, 'index']);
            // Route::get('/features/add', [FeaturesController::class, 'add']);
            // Route::post('/features/save', [FeaturesController::class, 'save']);
            // Route::get('/features/edit-{id}', [FeaturesController::class, 'edit']);
            // Route::post('/features/update-{id}', [FeaturesController::class, 'update']);
            // Route::get('/features/delete-{id}', [FeaturesController::class, 'delete']);
            // promotional banner
            // Route::group(
            //     ['prefix' => 'promotionalbanners'],
            //     function () {
            //         Route::get('/', [BannerController::class, 'promotional_banner']);
            //         Route::get('add', [BannerController::class, 'promotional_banneradd']);
            //         Route::get('edit-{id}', [BannerController::class, 'promotional_banneredit']);
            //         Route::post('save', [BannerController::class, 'promotional_bannersave_banner']);
            //         Route::post('update-{id}', [BannerController::class, 'promotional_bannerupdate']);
            //         Route::get('delete-{id}', [BannerController::class, 'promotional_bannerdelete']);
            //     }
            // );
            Route::post('/landingsettings', [SettingsController::class, 'landingsettings']);
        });
    });



    Route::middleware('VendorMiddleware')->group(function () {
        // Route::get('/admin_back', [UserController::class, 'admin_back']);

        // banner
        // Route::group(['prefix' => 'bannersection-1'], function () {
        //     Route::get('', [BannerController::class, 'index']);
        //     Route::get('/add', [BannerController::class, 'add']);
        //     Route::get('/edit-{id}', [BannerController::class, 'edit']);
        //     Route::post('/save-{section}', [BannerController::class, 'save_banner']);
        //     Route::post('/update-{id}', [BannerController::class, 'edit_banner']);
        //     Route::get('/status_change-{id}/{status}', [BannerController::class, 'status_update']);
        //     Route::get('/delete-{id}', [BannerController::class, 'delete']);
        // });
        // Route::group(['prefix' => 'bannersection-2'], function () {
        //     Route::get('', [BannerController::class, 'index']);
        //     Route::get('/add', [BannerController::class, 'add']);
        //     Route::get('/edit-{id}', [BannerController::class, 'edit']);
        //     Route::post('/save-{section}', [BannerController::class, 'save_banner']);
        //     Route::post('/update-{id}', [BannerController::class, 'edit_banner']);
        //     Route::get('/status_change-{id}/{status}', [BannerController::class, 'status_update']);
        //     Route::get('/delete-{id}', [BannerController::class, 'delete']);
        // });

        // share
        // Route::get('share', [OtherController::class, 'share']);
        
        // products
        // Route::group(['prefix' => 'products'], function () {
        //     Route::get('/', [ProductController::class, 'index']);
        //     Route::get('/add', [ProductController::class, 'add']);
        //     Route::post('/save', [ProductController::class, 'save']);
        //     Route::get('/edit-{slug}', [ProductController::class, 'edit']);
        //     Route::post('/update-{slug}', [ProductController::class, 'update']);
        //     Route::get('/delete-{slug}', [ProductController::class, 'delete']);
        //     Route::post('/update', [ProductController::class, 'update_image']);
        //     Route::get('/delete_image-{id}/{product_id}', [ProductController::class, 'delete_image']);
        //     Route::post('/add_image', [ProductController::class, 'add_image']);
        //     Route::get('/status_change-{slug}/{status}', [ProductController::class, 'status_change']);
        //     Route::get('/deletefeature-{id}', [ProductController::class, 'delete_feature']);
        // });
        // plan
        // Route::group(
        //     ['prefix' => 'plan'],
        //     function () {
        //         Route::get('selectplan-{id}', [PlanPricingController::class, 'select_plan']);
        //         Route::post('buyplan', [PlanPricingController::class, 'buyplan']);
        //         Route::get('buyplan/payment/success', [PlanPricingController::class, 'success']);
        //     }
        // );
        // working-hours
        // Route::get('/workinghours', [WorkinghoursController::class, 'index']);
        // Route::post('/workinghours/edit', [WorkinghoursController::class, 'edit']);

        // how works
        // Route::get('/how_works', [WorksController::class, 'index']);
        // Route::post('/how_works/savecontent', [WorksController::class, 'savecontent']);
        // Route::get('/how_works/add', [WorksController::class, 'add']);
        // Route::get('/how_works/edit-{id}', [WorksController::class, 'edit']);
        // Route::post('/how_works/update-{id}', [WorksController::class, 'update']);
        // Route::post('/how_works/save', [WorksController::class, 'save']);
        // Route::get('/how_works/delete-{id}', [WorksController::class, 'delete']);

        // why choose us
        // Route::get('/choose_us', [WhyChooseUsController::class, 'index']);
        // Route::post('/choose_us/savecontent', [WhyChooseUsController::class, 'savecontent']);
        // Route::get('/choose_us/add', [WhyChooseUsController::class, 'add']);
        // Route::get('/choose_us/edit-{id}', [WhyChooseUsController::class, 'edit']);
        // Route::post('/choose_us/update-{id}', [WhyChooseUsController::class, 'update']);
        // Route::post('/choose_us/save', [WhyChooseUsController::class, 'save']);
        // Route::get('/choose_us/delete-{id}', [WhyChooseUsController::class, 'delete']);

        // gallery
        // Route::group(['prefix' => 'gallery'], function () {
        //     Route::get('/', [GalleryController::class, 'index']);
        //     Route::get('/add', [GalleryController::class, 'add']);
        //     Route::post('/save', [GalleryController::class, 'save']);
        //     Route::get('/edit-{id}', [GalleryController::class, 'edit']);
        //     Route::post('/update-{id}', [GalleryController::class, 'update']);
        //     Route::get('/change_status-{id}/{status}', [GalleryController::class, 'status_change']);
        //     Route::get('/delete-{id}', [GalleryController::class, 'delete']);
        // });
         // locations
        //  Route::group(['prefix' => 'pickup_location'], function () {
        //     Route::get('/', [LocationController::class, 'index']);
        //     Route::get('/add', [LocationController::class, 'add']);
        //     Route::post('/save-{section}', [LocationController::class, 'save']);
        //     Route::get('/edit-{id}', [LocationController::class, 'edit']);
        //     Route::post('/update-{id}-{type}', [LocationController::class, 'update']);
        //     Route::get('/status_change-{id}/{status}', [LocationController::class, 'status_change']);
        //     Route::get('/delete-{id}-{type}', [LocationController::class, 'delete']);
        // });
        // Route::group(['prefix' => 'drop_location'], function () {
        //     Route::get('/', [LocationController::class, 'index']);
        //     Route::get('/add', [LocationController::class, 'add']);
        //     Route::post('/save-{section}', [LocationController::class, 'save']);
        //     Route::get('/edit-{id}', [LocationController::class, 'edit']);
        //     Route::post('/update-{id}-{type}', [LocationController::class, 'update']);
        //     Route::get('/status_change-{id}/{status}', [LocationController::class, 'status_change']);
        //     Route::get('/delete-{id}-{type}', [LocationController::class, 'delete']);
        // });
         // bookings
        //  Route::get('/bookings', [VendorBookingController::class, 'index']);
        //  Route::get('/bookings/status_change-{booking_number}/{status}', [VendorBookingController::class, 'status_change']);
        //  Route::get('/invoice-{booking_number}', [VendorBookingController::class, 'booking_invoice']);
         // Reports
      
        //  Route::get('/reports', [ReportController::class, 'index']);
        //  Route::get('/reports/status_change-{booking_number}/{status}', [ReportController::class, 'status_change']);
    });
});