<?php

namespace App\Components\ExpressionLanguage\Variables;

use App\Models\Task;
use App\Components\ExpressionLanguage\VariableContract;

class TaskFields implements VariableContract
{
    /**
     * @var Task
     */
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getValue()
    {
        return $this->task->scalar_fields;
    }
}
