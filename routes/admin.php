<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;

/*
    ADMINISTRATOR ROUTES | START
*/

Route::middleware(['auth', 'admin'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {

        /*
            DASHBOARD ROUTES | START
        */

        Route::get('/', AdminDashboardController::class)->name('dashboard');

        /*
            DASHBOARD ROUTES | END
        */


        /*
            ROLES ROUTES | START
        */

        Route::controller(RoleController::class)
            ->name('roles.')
            ->prefix('roles')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{role}', 'show')->name('show');
                Route::get('/{role}/edit', 'edit')->name('edit');
                Route::put('/{role}', 'update')->name('update');
                Route::delete('/{role}', 'destroy')->name('destroy');
            });

        /*
            ROLES ROUTES | END
        */




        /*
            USER ROUTES | START
        */

        Route::controller(AdminUserController::class)
            ->name('users.')
            ->prefix('users')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{user}', 'show')->name('show');
                Route::get('/{user}/edit', 'edit')->name('edit');
                Route::put('/{user}', 'update')->name('update');
                Route::delete('/{user}', 'destroy')->name('destroy');
            });

        /*
            USER ROUTES | END
        */



        /*
            POSTS ROUTES | START
        */

        Route::controller(AdminPostController::class)
            ->name('posts.')
            ->prefix('posts')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{post}', 'show')->name('show');
                Route::get('/{post}/edit', 'edit')->name('edit');
                Route::put('/{post}', 'update')->name('update');
                Route::delete('/{post}', 'destroy')->name('destroy');
                Route::post('/{post}/pin', 'togglePin')->name('pin');
                Route::post('/{post}/lock', 'toggleLock')->name('lock');
            });

        /*
            POSTS ROUTES | END
        */



        /*
            COMMENTS ROUTES | START
        */

        Route::controller(AdminCommentController::class)
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
    ADMINISTRATOR ROUTES | END
*/
