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



Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', "ImageController@index", function () {
        return view('image.index');
    })->name('home');   
    
    Route::resource('image', 'ImageController')->except(['index']);
    Route::get('image/save/{id}', 'ImageController@download')->name('image.download');
    Route::get('/my-feed', 'ImageController@feed')->name('my-feed');
    Route::get('/today', 'ImageController@today')->name('today');
    Route::get('/followings', 'ImageController@followings')->name('followings');
    Route::post('save-image', 'ImageController@saveImage')->name('image.save');
    
    Route::resource('board', 'BoardController')->except(['show', 'create']);
    Route::get('/board/create', 'BoardController@create')->name('board.create');
    Route::get('/{user_name}/{board_id}-{board_name}', 'BoardController@show')->name('board.show');
    Route::post('board-remove-image', 'BoardController@removeImage')->name('board.remove.image');


    Route::get('profil/{user_name}', 'UserController@show')->name('user.show');
    Route::get('follow/{user_id}', 'UserController@follow')->name('user.follow');
    Route::get('unfollow/{user_id}', 'UserController@unfollow')->name('user.unfollow');

});

Route::any('/search', 'SearchController@getSearch')->name('search');
