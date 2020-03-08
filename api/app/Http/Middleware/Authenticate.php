<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    protected $throughApi = false;

    public function handle($request, Closure $next, ...$guards)
    {
        $this->throughApi = in_array('api', $guards);
        return parent::handle($request, $next, ...$guards);
    }

    protected function redirectTo($request)
    {
        if (!$this->throughApi && !$request->expectsJson()) {
            return route('login');
        }
    }

}
