<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use CurrentOrganization;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        return [
            'api' => 'WFlow API',
            'version' => 1,
            'organization' => CurrentOrganization::get()
        ];
    }

}
