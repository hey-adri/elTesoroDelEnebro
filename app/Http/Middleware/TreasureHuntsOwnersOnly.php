<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TreasureHuntsOwnersOnly
{
    /**
     * Allows only those users that own the treasure hunt
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->route('treasureHunt')->user_id!=auth()?->user()->id) return redirect()->route('home')->with('toast', [
            'icon' => 'error',
            'text' => __('No tienes permiso para acceder a este recurso')
        ]);
        return $next($request);
    }
}
