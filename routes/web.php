<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Models\Post;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [Controller::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'post', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/', [PostController::class, 'form'])->name('post.form');
    Route::get('/{postId}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::get('/{postId}', [PostController::class, 'show'])->name('post.show');
    Route::post('/', [PostController::class, 'create'])->name('post.create');
    Route::delete('/{postId}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::patch('/', [PostController::class, 'update'])->name('post.update');
});

Route::group(['prefix' => 'comment', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/{postId}', [CommentController::class, 'getComments'])->name('comment');
    Route::get('/{commentId}/edit', [CommentController::class, 'editForm'])->name('comment.edit');
    Route::post('/', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::patch('/', [CommentController::class, 'update'])->name('comment.update');
});

Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/{userId}', [UserController::class, 'userPage'])->name('user.userPage');
    Route::post('/requestFollow', [UserController::class, 'requestFollow'])->name('user.reqFollow');
    Route::post('/requestUnfollow', [UserController::class, 'requestUnfollow'])->name('user.reqUnfollow');
});

Route::middleware(['auth:sanctum', 'verified'])->post('/vote', [VoteController::class, 'vote'])->name('vote');
Route::middleware(['auth:sanctum', 'verified'])->delete('/vote', [VoteController::class, 'devote'])->name('devote');
