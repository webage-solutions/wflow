<?php

namespace App\Components\ExpressionLanguage\Variables;

use App\Models\UserGroup;
use App\Components\ExpressionLanguage\VariableContract;
use Auth;

class LoggedUserGroups implements VariableContract
{

    public function getValue()
    {
        return Auth::user()->groups->map(function (UserGroup $group) {
            return $group->slug;
        })->toArray();
    }
}
