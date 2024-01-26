<?php

namespace App\Providers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class CustomValidatorServiceProvider extends ServiceProvider
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
        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            if (!preg_match('/^data:image\/(\w+);base64,/', $value)) {
                return false;
            }

            $data = base64_decode(preg_replace('/^data:image\/(\w+);base64,/', '', $value));

            if ($data === false) {
                return false;
            }

            $image = imagecreatefromstring($data);

            return $image !== false;
        });

        Validator::replacer('base64image', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute must be a valid base64-encoded image.');
        });

        Validator::extend('max10mb', function ($attribute, $value, $parameters, $validator) {
            return strlen(base64_decode($value)) <= 10240;
        });

        Validator::replacer('max10mb', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The :attribute must be less than or equal to 10MB.');
        });
    }
}
