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
})->name('home');   

Route::get('/today', 'ImageController@today')->name('today');

Route::middleware('auth')->group(function () {
    Route::resource('image', 'ImageController');
    Route::get('/my-feed', 'ImageController@feed')->name('my-feed');
    Route::get('/followings', 'ImageController@followings')->name('followings');
    Route::resource('board', 'BoardController')->except([
        'show', 'create'
    ]);
    Route::get('/board/create', 'BoardController@create')->name('board.create');
    Route::get('/{user_name}/{board_id}-{board_name}', 'BoardController@show')->name('board.show');
    Route::post('save-image', 'BoardController@addImage')->name('image.save');
    Route::get('image/save/{id}', [
        'as' => 'image.download',
        'uses' => 'ImageController@download'
    ]);
    Route::get('/{user_name}', 'UserController@show')->name('user.show');
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::any('/search', 'SearchController@getSearch')->name('search');