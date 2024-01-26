<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
                Route::middleware('web');

            Route::middleware('web')
                ->group(base_path('routes/blog.php'));
            Route::middleware('web')
                ->group(base_path('routes/coupon.php'));
            Route::middleware('web')
                ->group(base_path('routes/whatsappmessage.php'));
            Route::middleware('web')
                ->group(base_path('routes/telegrammessage.php'));
            Route::middleware('web')
                ->group(base_path('routes/myfatoorah.php'));
            Route::middleware('web')
                ->group(base_path('routes/paypal.php'));
            Route::middleware('web')
                ->group(base_path('routes/toyyibpay.php'));
            Route::middleware('web')
                ->group(base_path('routes/sociallogin.php'));
            Route::middleware('web')
                ->group(base_path('routes/customdomain.php'));
            Route::middleware('web')
                ->group(base_path('routes/launguage.php'));
            Route::middleware('web')
                ->group(base_path('routes/notification.php'));
            Route::middleware('web')
                ->group(base_path('routes/customers.php'));
        });
    }
}
