<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\StateNotFoundException;
use App\Exceptions\TransitionNotAllowedException;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TasksController extends Controller
{

    public function view(Task $task)
    {
        dd(\Settings::get('locale'));
        $task->addHidden('task_type');
        return $task;
    }

    public function executeTransition(Task $task, string $transition)
    {

        try {
            $task->execute($transition);
        } catch (StateNotFoundException $e) {
            throw new NotFoundHttpException('The state don\'t exists');
        } catch (TransitionNotAllowedException $e) {
            throw new AccessDeniedHttpException('This transition is not allowed');
        }
        return response()->noContent();
    }
}
