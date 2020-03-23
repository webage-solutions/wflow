<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;
use Illuminate\Http\Request;

class RedirectSingleOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $loggedUser */
        $loggedUser = Auth::user();

        if ($loggedUser->organizations->count() === 1) {
            return redirect(uiRoute($loggedUser->organizations[0]->main_domain));
        }
        return $next($request);
    }
}
