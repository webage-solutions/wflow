<?php

namespace App\Components\ExpressionLanguage\Bundles;

use App\Components\ExpressionLanguage\VariableBundleContract;
use App\Components\ExpressionLanguage\VariableContract;
use App\Components\ExpressionLanguage\Variables\LoggedUser;
use App\Components\ExpressionLanguage\Variables\LoggedUserGroups;

class ActiveWorkFlowForTaskTypeVariableBundle implements VariableBundleContract
{

    /**
     * @var array
     */
    protected $variables;

    public function __construct()
    {
        $variables = [
            'loggedUser' => new LoggedUser(),
            'loggedUserGroups' => new LoggedUserGroups(),
        ];
        $this->variables = array_map(function (VariableContract $variable) {
            return $variable->getValue();
        }, $variables);
    }

    public function getVariables(): array
    {
        return $this->variables;
    }
}
