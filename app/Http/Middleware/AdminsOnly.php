<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminsOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()?->user()?->isAdmin) return redirect()->route('userArea.index')->with('toast', [
            'icon' => 'error',
            'text' => __('No tienes permiso para acceder a esta funcionalidad')
        ]);
        return $next($request);
    }
}
