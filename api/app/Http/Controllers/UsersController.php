<?php

namespace App\Http\Controllers;

use App\Exceptions\StateNotFoundException;
use App\Exceptions\TransitionNotAllowedException;
use App\Models\Task;
use App\Models\User;
use Storage;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{

    public function avatar(int $userId)
    {
        $filename = "avatars/$userId.png";
        return Storage::download($filename);
    }
}
