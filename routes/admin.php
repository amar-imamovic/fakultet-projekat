<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

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
            });

        /*
            ROLES ROUTES | END
        */
    });


/*
    ADMINISTRATOR ROUTES | END
*/
