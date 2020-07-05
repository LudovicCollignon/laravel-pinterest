<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Image;
use App\ImageTag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class SearchController extends Controller
{
    public function getSearch(Request $request) {
        $q = Request::get( 'q' );
        $tags = Tag::where('name', 'LIKE', '%'.$q.'%')->get('id')->toArray();
        $images_tags = Imagetag::whereIn('tag_id', $tags)->get('image_id')->toArray();
        $images = Image::whereIn('id', $images_tags)->get();

        if(count($images) > 0)
            return view('image.index', [
                'images' => $images
            ]);
        else return view ('image.index', ['images' => []]);
    }
}