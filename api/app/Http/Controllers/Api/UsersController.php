<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Storage;

class UsersController extends Controller
{

    public function avatar(int $userId)
    {
        $filename = "avatars/$userId.png";
        return Storage::download($filename);
    }

    public function index()
    {
        return User::paginate();
    }

    public function search(string $query)
    {
        return User::search($query)->paginateHighlighted();
    }

    public function info(User $user)
    {
        return $user;
    }

}
