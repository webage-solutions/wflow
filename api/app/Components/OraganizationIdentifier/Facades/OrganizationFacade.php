<?php

namespace App\Components\OrganizationIdentifier\Facades;

use Illuminate\Support\Facades\Facade;

class OrganizationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'organization';
    }
}
