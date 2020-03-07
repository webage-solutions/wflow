<?php

namespace App\Http\Controllers;

use Auth;
use Settings;

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
}
