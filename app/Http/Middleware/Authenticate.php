<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        if ($request->is('admin*')) {
            return route('login');  // misal admin ke login biasa
        }

        if ($request->is('atasan*')) {
            return route('otp.email.form'); // atasan ke form input email OTP
        }

        if ($request->is('alumni*')) {
            return route('otp.email.form'); // alumni juga ke form input email OTP, atau ubah sesuai kebutuhan
        }

        return route('login');
    }
}
