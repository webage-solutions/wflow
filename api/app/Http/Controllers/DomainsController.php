<?php

namespace App\Http\Controllers;

use App\Models\DomainName;

class DomainsController extends Controller
{

    public function organization(DomainName $domain)
    {
        //return PublicOrganization::where('domain', $domain)->firstOrFail();
        return $domain->organization()->with('uiClient')->first();
    }
}
