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
        $board = new Board;

        $board->name = $request->boardName;
        $board->description = $request->boardDescription;
        $board->user_id = Auth::id();

        $board->save();

        return redirect()->route('board.show', [$board]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $board = Board::find($id);
        $images = $board->images;

        return view('board.show', [
            'board' => $board,
            'images' => $images
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
     * Add the specified image to the specified board.
     *
     * @param  Model  $image
     * @param  Model  $board
     * @return \Illuminate\Http\Response
     */
    public function addImage(Request $request)
    {   
        if (!isset($request->image))
            dd('erreur à gérer');

        $image = Image::find($request->image);
        
        if (NULL !== $request->board) {
            $board = Board::find($request->board);
            $board->images()->attach($image);
        }

        $user = User::find(Auth::id());

        $image->user()->associate($user);

        return redirect()->route('home');
    }
}
