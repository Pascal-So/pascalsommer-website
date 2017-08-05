<?php

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

Route::get('/', 'PostController@index')->name('home');
Route::post('posts', 'PostController@store');
Route::get('posts/create', 'PostController@create');
Route::get('posts/{post}', 'PostController@show');
Route::put('posts/{post}', 'PostController@update');
Route::delete('posts/{post}', 'PostController@destroy');
Route::get('posts/{post}/edit', 'PostController@edit');


Route::get('photos', 'PhotoController@index');
Route::post('photos', 'PhotoController@store');
Route::get('photos/upload', 'PhotoController@upload');
Route::get('photos/{photo}', 'PhotoController@show');
Route::put('photos/{photo}', 'PhotoController@update');
Route::delete('photos/{photo}', 'PhotoController@destroy');

Route::get('tags', 'TagController@index');
Route::post('tags', 'TagController@store');
Route::get('tags/create', 'TagController@create');
Route::get('tags/{tag}', 'TagController@show');
Route::put('tags/{tag}', 'TagController@update');
Route::delete('tags/{tag}', 'TagController@destroy');
Route::get('tags/{tag}/edit', 'TagController@edit');

Route::get('comments', 'CommentController@index');
Route::post('photos/{photo}/addComment', 'CommentController@add');
Route::delete('comments/{comment}', 'CommentController@destroy');


Route::get('login', 'Auth\LoginController@showLoginForm')->middleware('guest')->name('login');
Route::post('login', 'Auth\LoginController@login')->middleware('guest');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('admin', function(){
	return view('admin.admin');
})->name('admin');
