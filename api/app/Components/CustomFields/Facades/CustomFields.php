<?php

namespace App\Components\CustomFields\Facades;

use Illuminate\Support\Facades\Facade;

class CustomFields extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'customfields';
    }
}
