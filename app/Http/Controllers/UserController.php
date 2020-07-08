<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
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

    /**
     * add a user to the followee list of the logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function follow(Request $request)
    {
        $currentUser = User::find(Auth::id());
        
        $followee = User::find($request->user_id);

        $currentUser->followees()->attach($followee);

        return back();
    }
}
