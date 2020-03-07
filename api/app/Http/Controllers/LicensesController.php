<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddLicenseRequest;
use App\Models\License;

class LicensesController extends Controller
{
    public function add(AddLicenseRequest $request)
    {
        return 'add license';
    }

    public function deactivate(License $license)
    {
    }
}
