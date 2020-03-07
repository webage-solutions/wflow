<?php

namespace App\Components\ExpressionLanguage\Variables;

use App\Components\ExpressionLanguage\VariableContract;

class LoggedUser implements VariableContract
{

    public function getValue()
    {
        return \Auth::user()->email;
    }
}
