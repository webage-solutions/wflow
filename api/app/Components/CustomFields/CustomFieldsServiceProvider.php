<?php

namespace App\Components\CustomFields;

use App;
use Illuminate\Support\ServiceProvider;

class CustomFieldsServiceProvider extends ServiceProvider
{
    public function register()
    {
        App::bind('customfields', CustomFields::class);
    }
}
