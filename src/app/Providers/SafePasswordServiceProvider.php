<?php

namespace App\Providers;

use App\Rules\SafePassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class SafePasswordServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Validator::extend('safe_password', function ($attribute, $value, $parameters, $validator) {
            $rule = new SafePassword();
            return $rule->passes($attribute, $value);
        });

        Validator::replacer('safe_password', function ($message, $attribute, $rule, $parameters) {
            $messages = (new SafePassword())->message();

            if (isset($messages['safe_password'])) {
                return str_replace(':attribute', $attribute, $messages['safe_password']);
            }

            return $message;
        });
    }
}
