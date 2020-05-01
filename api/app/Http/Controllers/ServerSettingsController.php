<?php

namespace App\Http\Controllers;

use Settings;

class ServerSettingsController extends Controller
{
    public function index()
    {
        return Settings::getServerSettings();
    }
}
