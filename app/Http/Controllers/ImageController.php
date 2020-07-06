<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;
use App\Image;
use App\ImageTag;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
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
        $image = InterventionImage::make($request->image)->widen($screen_width / 5)->encode();
        Storage::put('/public/thumbs/' . $path, $image);

        $image = new Image;
        $image->user_id = "1";
        $image->description = "";
        $image->title = $request->title;
        $image->filename = $path;
        
        //save images with categories in another method
        $image->save();
        
        $image->boards()->attach($request->board);


        /* tags */

        // tags name from form
        $tags = explode(',',$request->tags);

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

    public function download($imageId){
        $image = Image::where('id', $imageId)->firstOrFail();
        $path = public_path(). '/storage/images/'. $image->filename;
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

        $tags = ImageTag::where('image_id', $image->id)->get('tag_id')->toArray();
        $images = Image::whereIn('id', ImageTag::whereIn('tag_id', $tags)->get('image_id')->toArray())->where('id', '!=', $image->id)->get();

        $user = User::find($image->user_id);

        return view('image.show', [
            'image' => $image,
            'user' => $user,
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
}
