<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;
use App\Board;
use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $images = Image::all();
        $boards = User::find(Auth::id())->boards;

        return view('image.index', [
            'images' => $images,
            'boards' => $boards
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $boards = User::find(Auth::id())->boards;

        return view('image.create', ["boards" => $boards]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get file by input name => "image"
        $image = $request->image;

        // save image in storage/app/public/images/ with random filename
        $path = basename($image->store('/public/images'));

        // save thumbs in storage/app/public/thumbs/ with sameName
        $screen_width = $_COOKIE['screenWidth'];
        $image = InterventionImage::make($request->image)->widen(400)->encode('jpg');
        Storage::put('/public/thumbs/' . $path, $image);

        // save image
        $image = new Image;
        $image->user_id = Auth::id();
        $image->description = $request->description;
        $image->title = $request->title;
        $image->filename = $path;

        $image->save();

        // attach image to board if it exists
        if (isset($request->board))
            $image->boards()->attach($request->board);


        // add image to user gallery
        $user = User::find(Auth::id());

        $user->uploaded_images()->attach($image);

        /* tags */

        // tags name from form
        $tags = explode(',', $request->tags);

        // existent tags modele matches withs $tags
        $existentTags = Tag::whereIn('name', $tags)->get();

        // key => tagName , value => Tag modele
        $existentTagsByName = [];

        foreach ($existentTags as $tag) {
            $existentTagsByName[$tag->name] = $tag;
        }

        foreach ($tags as $tag) {

            if (!array_key_exists($tag, $existentTagsByName)) {
                $imageTag = new Tag;
                $imageTag->name = $tag;
                $imageTag->save();
            } else {
                $imageTag = $existentTagsByName[$tag];
            }

            $image->tags()->attach($imageTag);
        }

        return redirect()->route('image.index');
    }

    public function download($imageId)
    {
        $image = Image::where('id', $imageId)->firstOrFail();
        $path = public_path() . '/storage/images/' . $image->filename;
        return response()->download($path, $image->title, ['Content-Type' => $image->mime]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Image::find($id);

        $tags = $image->tags()->get();

        $images = [];

        foreach ($tags as $tag) {
            $images = array_merge($images, $tag->images()->where('image_id', '!=', $image->id)->get()->all());
        }

        // $tags = ImageTag::where('image_id', $image->id)->get('tag_id')->toArray();

        // foreach()

        // $images = Image::whereIn('id', ImageTag::whereIn('tag_id', $tags)->get('image_id')->toArray())->where('id', '!=', $image->id)->get();

        $user = User::find($image->user_id);

        $boards = $user->boards;

        return view('image.show', [
            'image' => $image,
            'user' => $user,
            'images' => $images, 
            'boards'=> $boards
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
    public function saveImage(Request $request)
    {
        if (!isset($request->image))
            dd('erreur à gérer');

        $image = Image::find($request->image);

        if (NULL !== $request->board) {
            $board = Board::find($request->board);
            $board->images()->attach($image);
        }

        $user = User::find(Auth::id());

        $user->uploaded_images()->attach($image);

        return redirect()->route('home');
    }
}
