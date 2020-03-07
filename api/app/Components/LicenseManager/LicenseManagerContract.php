<?php

namespace App\Components\LicenseManager;

interface LicenseManagerContract
{
    public function parseLicenseFile();

    public function validateLicense();
}
