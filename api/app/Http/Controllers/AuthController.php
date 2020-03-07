<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{

    public function logout()
    {
        Auth::user()->token()->revoke();
        return response()->noContent(204);
    }

}
