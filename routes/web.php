<?php

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

Auth::routes();

Route::get('about', function () {
    return view('about');
})->name('about');

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/home', [App\Http\Controllers\PostController::class, 'index'])->name('home');
Route::get('/addPost', [App\Http\Controllers\PostController::class, 'create'])->name('addPost');
Route::post('/store', [App\Http\Controllers\PostController::class, 'store'])->name('store');

Route::get('/user/{name}', [App\Http\Controllers\UserController::class, 'show'])->name('showUser');

Route::get('/posts/{name}', [App\Http\Controllers\PostController::class, 'show'])->name('show');
Route::get('/delete/{id}', [App\Http\Controllers\PostController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [App\Http\Controllers\PostController::class, 'edit'])->name('edit');
Route::any('/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('update');
Route::get('/post/{id}/{title}', [App\Http\Controllers\PostController::class, 'showPost'])->name('postForm');

Route::get('/deleteUser/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('deleteUser');

Route::get('/deleteComment/{name}/{id}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('deleteComment');
Route::post('/storeComment/{id}', [App\Http\Controllers\CommentController::class, 'store'])->name('storeComment');

Route::get('/editUser/{name}', [App\Http\Controllers\UserController::class, 'edit'])->name('editUser');
Route::any('/updateUser/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('updateUser');

Route::get('/editComment/{id}', [App\Http\Controllers\CommentController::class, 'edit'])->name('editComment');
Route::any('/updateComment/{id}', [App\Http\Controllers\CommentController::class, 'update'])->name('updateComment');

Route::get('/deletePicture/{id}', [App\Http\Controllers\PostController::class, 'destroyPicture'])->name('deletePicture');

Route::get('/deleteUserPicture/{id}', [App\Http\Controllers\UserController::class, 'destroyPicture'])->name('deleteUserPicture');

Route::get('/deleteCommentPicture/{id}', [App\Http\Controllers\CommentController::class, 'destroyPicture'])->name('deleteCommentPicture');

