<?php

namespace App\Components\ExpressionLanguage\Bundles;

use App\Models\Task;
use App\Components\ExpressionLanguage\VariableBundleContract;
use App\Components\ExpressionLanguage\VariableContract;
use App\Components\ExpressionLanguage\Variables\LoggedUser;
use App\Components\ExpressionLanguage\Variables\LoggedUserGroups;
use App\Components\ExpressionLanguage\Variables\TaskFields;

class TaskTransitionConditionVariableBundle implements VariableBundleContract
{

    /**
     * @var array
     */
    protected $variables;

    /**
     * TaskTransitionConditionVariableBundle constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $variables = [
            'loggedUser' => new LoggedUser(),
            'loggedUserGroups' => new LoggedUserGroups(),
            'taskFields' => new TaskFields($task),
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
