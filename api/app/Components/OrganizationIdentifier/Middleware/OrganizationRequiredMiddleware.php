<?php

namespace App\Components\OrganizationIdentifier\Middleware;

use App\Components\OrganizationIdentifier\Facades\OrganizationFacade;
use App\Models\Organization;
use App\Models\User;
use Auth;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrganizationRequiredMiddleware
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next)
    {

        if (OrganizationFacade::get() === null) {
            throw new HttpException(400, 'Organization is required');
        }

        return $next($request);
    }
}
