<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Storage;

class UsersController extends Controller
{

    public function avatar(int $userId)
    {
        $filename = "avatars/$userId.png";
        return Storage::download($filename);
    }
}
