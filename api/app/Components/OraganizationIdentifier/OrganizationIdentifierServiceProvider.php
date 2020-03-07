<?php

namespace App\Components\OrganizationIdentifier;

use App;
use Illuminate\Support\ServiceProvider;

class OrganizationIdentifierServiceProvider extends ServiceProvider
{
    public function register()
    {
        App::bind('organization', function() {
            return new OrganizationIdentifier();
        });
    }
}
