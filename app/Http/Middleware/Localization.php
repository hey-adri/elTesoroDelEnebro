<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request to set its locale from session value.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $browserDefaultLocale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $sessionLocale = session('locale');
        App::setLocale(($sessionLocale)?$sessionLocale:$browserDefaultLocale);
        return $next($request);
    }
}
