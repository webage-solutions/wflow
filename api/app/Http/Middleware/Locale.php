<?php

namespace App\Http\Middleware;

use App\Components\Settings\Settings;
use Carbon\Carbon;
use Closure;

class Locale
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
        \App::setLocale($this->findLocale());
        return $next($request);
    }

    protected function findLocale()
    {
        // first check if the lang variable is set on the query string (locale defined on the client)
        if ($locale = request()->query('lang', null)) {
            return $locale;
        }

        // than check if the X-Wflow-Locale header is set (locale defined on the client)
        if ($locale = request()->header('X-Wflow-Locale')) {
            return $locale;
        }

        // finally check the settings
        return \Settings::get('locale');
    }
}
