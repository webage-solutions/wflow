<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Collection;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var User $loggedUser */
        $loggedUser = Auth::user();
        return view('home', [
            'protocol' => request()->secure() ? 'https' : 'http',
            'organizations' => $loggedUser->organizations,
        ]);
    }
}
