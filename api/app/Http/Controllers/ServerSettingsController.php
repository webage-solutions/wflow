<?php

namespace App\Http\Controllers;

class ServerSettingsController extends Controller
{
    public function index()
    {
        return \Settings::getServerSettings();
    }
}
