<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;
use App\Board;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
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
        if (Auth::check()) {
            $boards = User::find(Auth::id())->boards;

            return view('image.index', [
                'images' => $images,
                'boards' => $boards
            ]);
        } else {
            return view('image.index', [
                'images' => $images
            ]);
        }
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

        $request->validate([
            'image' => 'mimes:jpeg,jpg,png',
            'board' => 'required',
            'title' => 'max:255|required',
        ], [
            'board.required' => 'Please choose a board or create a new one.',
        ]);

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

        return redirect()->route('home');
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

        $images = new Collection;

        foreach ($tags as $tag) {
            $images = $images->merge($tag->images()->where('image_id', '!=', $image->id)->get());
        }

        $user = User::find($image->user_id);
        $currentUser = User::find(Auth::id());

        $isFollowed = false;

        if ($user->id !== Auth::id())
            $isFollowed = $currentUser->followees()->where('followee_id', $user->id)->get()->isNotEmpty();


        $boards = $user->boards;

        return view('image.show', [
            'image' => $image,
            'user' => $user,
            'images' => $images,
            'boards' => $boards,
            'isFollowed' => $isFollowed,
        ]);
    }

    public function today(Request $request)
    {
        $images = Image::whereDate('created_at', date('Y-m-d'))->get();
        $boards = User::find(Auth::id())->boards;

        return view('image.index', [
            'images' => $images,
            'boards' => $boards
        ]);
    }

    public function feed(Request $request)
    {
        $user = User::find(Auth::id());
        $boards = $user->boards;

        $tags = new Collection;

        foreach ($boards as $board) {
            $images = $board->images;
            foreach ($images as $image) {
                $tags = $tags->merge($image->tags()->get());
            }
        }

        $images = new Collection;

        foreach ($tags as $tag) {
            $images = $images->merge($tag->images()->get());
        }

        return view('image.index', [
            'images' => $images,
            'boards' => $boards
        ]);
    }

    public function followings(Request $request)
    {
        $followees = User::find(Auth::id())->followees;

        $images = new Collection;

        if (!is_null($followees)) {
            foreach ($followees as $followee) {
                $images = $images->merge($followee->images()->get());
            }
        }

        $boards = User::find(Auth::id())->boards;

        return view('image.index', [
            'images' => $images,
            'boards' => $boards
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
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'board' => 'required',
        ], [
            'image.required' => 'An error has occured, the image is not identified.',
            'board.required' => 'Please choose a board or create a new one.'
        ])->validate();



        $image = Image::find($request->image);

        if (NULL !== $request->board) {
            $board = Board::find($request->board);

            $imageExistent = $board->images()->where('image_id', $image->id)->get();

            if ($imageExistent->isEmpty()) {
                $board->images()->attach($image);
            } else {
                $errors = new MessageBag;
                $errors->add('image.exist', 'This image already exist in your board.');
            }
        }

        $user = User::find(Auth::id());

        $user->uploaded_images()->attach($image);

        return redirect()->route('home')->withErrors($errors);
    }
}
