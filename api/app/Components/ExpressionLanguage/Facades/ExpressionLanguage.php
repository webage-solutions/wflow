<?php

namespace App\Components\ExpressionLanguage\Facades;

use Illuminate\Support\Facades\Facade;

class ExpressionLanguage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'expressionlanguage';
    }
}
