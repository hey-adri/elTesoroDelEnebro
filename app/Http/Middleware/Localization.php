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
        //By default, we'll use the fallback locale
        $finalLocale = app()->getFallbackLocale();
        $availableLocales = array_values(config('app.available_locales'));
        //Checking if browserDefault is supported
        $browserDefaultLocale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if(in_array($browserDefaultLocale,$availableLocales)){
            //Supported, saving unless there's value in session
            $finalLocale = $browserDefaultLocale;
        }
        $sessionLocale = session('locale');
        //Setting final locale
        App::setLocale(($sessionLocale)?$sessionLocale:$finalLocale);
        return $next($request);
    }
}
