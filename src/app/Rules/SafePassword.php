<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SafePassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->isSafePassword($value);
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function message()
    {
        return [
            'safe_password' => 'The :attribute must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one numeric digit and one symbol.',
        ];
    }

    /**
     * Determine if the given value is a safe password.
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function isSafePassword($value)
    {
        return strlen($value) >= 8 &&
               preg_match('/[A-Z]/', $value) &&
               preg_match('/[a-z]/', $value) &&
               preg_match('/[0-9]/', $value) &&
               preg_match('/[^A-Za-z0-9]/', $value);
    }
}
