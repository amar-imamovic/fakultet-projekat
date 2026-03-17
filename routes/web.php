<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Moderator\DashboardController as ModeratorDashboardController;

Route::get('/', function () {
    return view('welcome');
});


/*
    USER ROUTES | START
*/

Route::middleware(['auth', 'verified'])->get('/dashboard', UserDashboardController::class)->name('dashboard');

Route::middleware('auth')
    ->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        /*
            POSTS ROUTES | START
        */

        Route::controller(PostController::class)
            ->name('posts.')
            ->prefix('posts')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{post}', 'show')->name('show');
                Route::get('/{post}/edit', 'edit')->name('edit');
                Route::put('/{post}', 'update')->name('update');
                Route::delete('/{post}', 'destroy')->name('destroy');
            });

        /*
            POSTS ROUTES | END
        */



        /*
            COMMENTS ROUTES | START
        */

        Route::controller(CommentController::class)
            ->name('comments.')
            ->prefix('posts/{post}/comments')
            ->group(function () {
                Route::post('/', 'store')->name('store');
                Route::delete('/{comment}', 'destroy')->name('destroy');
            });

        /*
            COMMENTS ROUTES | END
        */



        /*
            LIKES ROUTES | START
        */

        Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');

        /*
            LIKES ROUTES | END
        */
    });

/*
    USER ROUTES | END
*/


/*
    MODERATOR ROUTES | START
*/

Route::middleware(['auth', 'moderator'])
    ->prefix('moderator')
    ->group(function () {
        Route::get('/', ModeratorDashboardController::class)->name('moderator.dashboard');
    });

/*
    MODERATOR ROUTES | END
*/


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/moderator.php';
