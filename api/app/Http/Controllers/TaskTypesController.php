<?php

namespace App\Http\Controllers;

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

    public function view(TaskType $taskType)
    {
        return $taskType;
    }
}