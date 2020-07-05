<?php

use App\Tag;
use App\Image;
use App\ImageTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

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


Route::middleware('auth')->group(function () {
    Route::resource('image', 'ImageController');
    Route::resource('board', 'BoardController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::any('/search', 'SearchController@getSearch')->name('search-tag');