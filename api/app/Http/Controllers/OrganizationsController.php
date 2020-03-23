<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Auth;
use CurrentOrganization;
use Illuminate\Http\Request;
use Settings;
use Storage;

class OrganizationsController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $loggedUser */
        $loggedUser = Auth::user();

        return view('organizations.index', ['organizations' => $loggedUser->organizations]);
    }

}
