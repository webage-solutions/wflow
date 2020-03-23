<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as traitLogout;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

//    /**
//     * @param Request $request
//     * @param string $autoLoginHash
//     * @return Response|Redirector
//     */
//    public function autoLogin(Request $request, string $autoLoginHash)
//    {
//        $loginInfo = Cache::get('auto-login-' . $autoLoginHash);
//
//        if ($loginInfo === null) {
//            return redirect('/auth/login');
//        }
//
//        $user = User::findOrFail($loginInfo['userId']);
//
//        Auth::login($user, $loginInfo['remember']);
//        return $this->sendLoginResponse($request);
//
//    }

    public function redirectTo()
    {
        return '/web/home';
    }

    public function logout(Request $request)
    {
        $this->traitLogout($request);
        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/web/login');
    }

}
