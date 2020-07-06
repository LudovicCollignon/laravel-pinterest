<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;
use App\Image;
use App\ImageTag;
use Illuminate\Http\Request;
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

        return view('image.index', [
            'images' => $images
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('image.create');
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

        $tags = explode(',',$request->tags);

        foreach ($tags as $t) {

            $tag = Tag::where('name', $t)->first();
            if (empty($tag)) {
                $tag = new Tag;

                $tag->name = $t;
                $tag->save();
            }

            $image_tag = new ImageTag;

            $image_tag->image_id = $image->id;
            $image_tag->tag_id = $tag->id;

            $image_tag->save();
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
        $user = User::find($image->user_id);

        return view('image.show', [
            'image' => $image,
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
}
