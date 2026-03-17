<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Moderator\DashboardController as ModeratorDashboardController;
use App\Http\Controllers\Moderator\PostController as ModeratorPostController;
use App\Http\Controllers\Moderator\CommentController as ModeratorCommentController;

/*
    MODERATOR ROUTES | START
*/

Route::middleware(['auth', 'moderator'])
    ->name('moderator.')
    ->prefix('moderator')
    ->group(function () {

        /*
            DASHBOARD ROUTES | START
        */

        Route::get('/', ModeratorDashboardController::class)->name('dashboard');

        /*
            DASHBOARD ROUTES | END
        */



        /*
            POSTS ROUTES | START
        */

        Route::controller(ModeratorPostController::class)
            ->name('posts.')
            ->prefix('posts')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{post}', 'show')->name('show');
                Route::post('/{post}/lock', 'toggleLock')->name('lock');
                Route::delete('/{post}', 'destroy')->name('destroy');
            });

        /*
            POSTS ROUTES | END
        */



        /*
            COMMENTS ROUTES | START
        */

        Route::controller(ModeratorCommentController::class)
            ->name('comments.')
            ->prefix('comments')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::delete('/{comment}', 'destroy')->name('destroy');
            });

        /*
            COMMENTS ROUTES | END
        */
    });


/*
    MODERATOR ROUTES | END
*/
