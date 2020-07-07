<?php

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
    Route::resource('board', 'BoardController')->except(['show', 'create']);
    Route::get('image/save/{id}', 'ImageController@download')->name('image.download');
    Route::get('/my-feed', 'ImageController@feed')->name('my-feed');
    Route::get('/followings', 'ImageController@followings')->name('followings');
    Route::get('/board/create', 'BoardController@create')->name('board.create');
    Route::get('/{user_name}/{board_id}-{board_name}', 'BoardController@show')->name('board.show');
    Route::get('/{user_name}', 'UserController@show')->name('user.show');
    Route::post('save-image', 'ImageController@saveImage')->name('image.save');
    Route::post('board-remove-image', 'BoardController@removeImage')->name('board.remove.image');
});

Auth::routes();

Route::any('/search', 'SearchController@getSearch')->name('search');