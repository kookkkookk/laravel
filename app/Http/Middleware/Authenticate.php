<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    /*
    // 主要是做授權不通過的 redirect
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login'); // 導到 login 頁
        }
    }
    */
}
