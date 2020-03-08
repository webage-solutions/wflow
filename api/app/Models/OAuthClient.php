<?php

namespace App\Models;

use Laravel\Passport\Client;

/**
 * Class OAuthClient - Passport Client override to allow skipping authorization
 *
 * @package App\Models
 * @property bool auto_authorize
 */
class OAuthClient extends Client
{
    public function skipsAuthorization()
    {
        return $this->auto_authorize;
    }
}
