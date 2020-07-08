<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Collection;

class SearchController extends Controller
{
    public function getSearch(Request $request)
    {
        $q = Request::get('q');

        $tags = Tag::where('name', 'LIKE', '%' . $q . '%')->get();
        $images_by_tags = new Collection;
        foreach ($tags as $tag) {
            $images_by_tags = $images_by_tags->merge($tag->images()->get());
        }

        $images_by_title = Image::where('title', 'LIKE', '%' . $q . '%')->get();

        $images = $images_by_tags->merge($images_by_title);

        return view('image.index', [
            'images' => $images
        ]);
    }
}
