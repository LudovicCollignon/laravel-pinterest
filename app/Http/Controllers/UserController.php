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
    public function show(Request $request)
    {
        $user = User::where('name', $request->user_name)->first();

        $boards = $user->boards;

        $currentUser = User::find(Auth::id());

        $isFollowed = false;

        if ( $user->id !== Auth::id())            
            $isFollowed = $currentUser->followees()->where('followee_id', $user->id)->get()->isNotEmpty();

        return view('user.show', [
            'user' => $user,
            'boards' => $boards,
            'isFollowed' => $isFollowed
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

    /**
     * remove a user to the followee list of the logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function unfollow(Request $request)
    {
        $currentUser = User::find(Auth::id());
        
        $followee = User::find($request->user_id);

        $currentUser->followees()->detach($followee);

        return back();
    }
}
