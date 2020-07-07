<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function show($user_name)
    {
        $boards = User::find(Auth::id())->boards;

        return view('user.show', [
            'boards' => $boards
        ]);
    }
}