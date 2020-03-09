<?php

namespace App\Http\Controllers;

use App\Models\DomainName;

class DomainsController extends Controller
{

    public function organization(DomainName $domain)
    {
        return $domain->publicOrganization()->with('uiClient')->first();
    }
}
