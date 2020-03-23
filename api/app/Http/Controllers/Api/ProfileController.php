<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Cache;
use Settings;
use Str;

class ProfileController extends Controller
{
    public function show()
    {
        return Auth::user()->load('organizations');
    }

    public function indexSettings()
    {
        return Settings::getUserSettings(Auth::user());
        //return Auth::user()->settings;
    }

    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function generateAutoLogin()
    {
        $hash = Str::random(64);
        $key = "auto-login-$hash";
        $loginInfo = [
            'userId' => Auth::user()->id,
            'remember' => false,
        ];
        $ttl = 30; // valid for 1 minute
        Cache::set($key, $loginInfo, $ttl);
        return ['auto_login_hash' => $hash, 'expires_in' => $ttl];
    }
}
