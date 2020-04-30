<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskType;

/**
 * Class TaskTypesController
 * @package App\Http\Controllers
 */
class TaskTypesController extends Controller
{

    public function index()
    {
        return TaskType::paginate();
    }

    public function search(string $query)
    {
        return TaskType::search($query)->paginate();
    }

    public function info(TaskType $taskType)
    {
        return $taskType;
    }

    public function workflows(TaskType $taskType)
    {
        return $taskType->workflows;
    }
}
