<?php

use App\Tag;
use App\Image;
use App\ImageTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "ImageController@index", function () {
    return view('image.index');
});


Route::middleware ('auth')->group (function () {
    Route::resource ('image', 'ImageController', [
        'only' => ['index', 'create', 'store', 'destroy', 'update']
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::any('/search',function(){
    $q = Request::get( 'q' );
    $tags = Tag::where('name', 'LIKE', '%'.$q.'%')->get('id')->toArray();
    $images_tags = Imagetag::whereIn('tag_id', $tags)->get('image_id')->toArray();
    $images = Image::whereIn('id', $images_tags)->get();

    if(count($images) > 0)
        return view('image.index', [
            'images' => $images
        ]);
    else return view ('image.index', ['images' => []]);
});