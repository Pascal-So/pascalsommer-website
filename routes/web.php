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

/*
|  Post Routes
*/

Route::get('/', 'PostController@index')
    ->name('home');

Route::middleware(['auth'])->group(function(){
    Route::get('/posts', 'PostController@adminIndex')
        ->name('posts');

    Route::get('/posts/{post}/edit', 'PostController@edit')
        ->name('editPost');

    Route::post('/posts/{post}', 'PostController@update')
        ->name('updatePost');

    Route::get('/posts/{post}/delete', 'PostController@delete')
        ->name('deletePost');
});

/*
|  Comment Routes
*/

Route::post('/photos/{photo}/comment', 'CommentController@postComment')
    ->name('postComment');

Route::middleware(['auth'])->group(function(){
    Route::get('/comments', 'CommentController@adminIndex')
        ->name('comments');

    Route::get('/comments/{comment}/delete', 'CommentController@delete')
        ->name('deleteComment');
});


/*
|  Photo Routes
*/

Route::get('/photos/{photo}', 'PhotoController@view')
    ->name('viewPhoto');

Route::middleware(['auth'])->group(function(){
    Route::get('/photos', 'PhotoController@adminIndex')
        ->name('photos');

    Route::get('/photos/{photo}/edit', 'PhotoController@edit')
        ->name('editPhoto');

    Route::post('/photos/{photo}', 'PhotoController@update')
        ->name('updatePhoto');

    Route::get('/photos/{photo}/delete', 'PhotoController@delete')
        ->name('deletePhoto');
});


Route::middleware(['auth'])->group(function(){
    Route::get('/staging', 'PhotoController@staging')
        ->name('staiging');

    Route::get('/upload', 'PhotoController@showUploadForm')
        ->name('uploadForm');

    Route::post('/upload', 'PhotoController@upload')
        ->name('upload');
});


/*
|  Auth Routes
*/

Route::get('/login', 'Auth\LoginController@showLoginForm')->middleware('guest')
    ->name('login');

Route::post('/login', 'Auth\LoginController@login')->middleware('guest');

Route::get('/logout', 'Auth\LoginController@logout')
    ->name('logout');