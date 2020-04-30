<?php

namespace App\Components\OrganizationIdentifier\Middleware;

use App\Components\OrganizationIdentifier\Facades\OrganizationFacade;
use App\Models\DomainName;
use App\Models\Organization;
use App\Models\User;
use Auth;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrganizationMiddleware
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next)
    {

        if (!preg_match('/^https?:\/\/(.+)$/', $request->root(), $matches)) {
            throw new HttpException('Invalid domain name');
        }

        /** @var DomainName $domain */
        if ($domain = DomainName::where('domain', $matches[1])->first()) {

            // if there is a logged user...
            /** @var User $loggedUser */
            $loggedUser = Auth::user();
            if ($loggedUser instanceof User) {

                // check if the user is member of the organization (if it's not, throws authorization exception)
                //it should never happen, if happens, it's a UI problem, or an attack
                if (!$loggedUser->organizations->contains($domain->organization)) {
                    Log::critical("User `{$loggedUser->email}` that is not part of organization `{$domain->organization->name}` trying to access it. Potential attack...");
                    throw new AuthorizationException('The user is not a member of this organization.');
                }

            }

            OrganizationFacade::set($domain->organization);

        }

        return $next($request);
    }
}
