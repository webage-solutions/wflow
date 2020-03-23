<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DomainName;

class DomainsController extends Controller
{

    public function organization(DomainName $domain)
    {
        return $domain->publicOrganization()->with('uiClient')->first();
    }
}
