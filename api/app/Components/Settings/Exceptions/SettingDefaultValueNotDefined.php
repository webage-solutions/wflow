<?php

namespace App\Components\Settings\Exceptions;

use Exception;
use Throwable;

class SettingDefaultValueNotDefined extends Exception
{
    public function __construct(string $setting)
    {
        parent::__construct("The setting `$setting` don't have a default value defined.`");
    }
}
