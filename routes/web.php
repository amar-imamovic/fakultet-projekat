<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
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
