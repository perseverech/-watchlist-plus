<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // If user has chosen a language, apply it to every request
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }
        return $next($request);
    }
}
