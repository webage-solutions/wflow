<?php

namespace App\Models;

use Laravel\Passport\Client;

/**
 * Class OAuthClient - Passport Client override to allow skipping authorization
 *
 * @package App\Models
 */
class OAuthClient extends Client
{
    public function skipsAuthorization()
    {
        return true; // TODO - Include a column on the database to ensure that only the WebApp skips this authorization
    }
}
