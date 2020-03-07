<?php

namespace App\Http\Middleware;

use Closure;

class AddHeaderAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('token')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->get('token'));
        }
        return $next($request);
    }
}
