<?php

namespace App\Http\Controllers;

use App\User;
use App\Board;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $boards = User::find(Auth::id())->boards;
        return view('board.index', ['boards' => $boards]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('board.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'boardName' => 'required',
        ]);

        $board = new Board;

        $board->name = $request->boardName;
        $board->description = $request->boardDescription;
        $board->user_id = Auth::id();

        $board->save();

        return redirect()->route('board.show', [
            'user_name' => Auth::user()->name, 
            'board_id' => $board->id, 
            'board_name' => $board->name
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = User::where('name', $request->user_name)->first();
        $board = Board::find($request->board_id);
        $images = $board->images;
        $boards = User::find(Auth::id())->boards;

        return view('board.show', [
            'board' => $board,
            'boards' => $boards,
            'images' => $images,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified image from the board.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function removeImage(Request $request)
    {
        $board = Board::find($request->board);
        $image = Image::find($request->image);

        $board->images()->detach($image);

        $userName = Auth::user()->name;

        return redirect()->route('board.show', [
            'user_name' => $userName,
            'board_id' => $board->id,
            'board_name' => $board->name
        ]);
    }
}
