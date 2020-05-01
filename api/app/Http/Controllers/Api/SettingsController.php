<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Settings;

class SettingsController extends Controller
{

    public function index()
    {
        return Settings::getEffectiveSettings();
    }

    public function categories()
    {
        return config('settings.categories');
    }
}
