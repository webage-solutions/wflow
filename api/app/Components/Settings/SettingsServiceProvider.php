<?php

namespace App\Components\Settings;

use App;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public function register()
    {
        App::singleton('settings', function() {
            return new Settings();
        });
    }
}
