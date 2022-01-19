<?php

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/temp', function () {
        return 'nothing';
    })->name('other');
});

Route::prefix('invitation')->name('invitation.')->group(function () {
    Route::name('accept.')->group(function () {
        Route::get('accept/{invitation:uuid}', [\App\Auth\Controllers\AcceptInvitationController::class, 'create'])
            ->name('create');

        Route::post('accept', [\App\Auth\Controllers\AcceptInvitationController::class, 'store'])
            ->name('store');
    });
});

require __DIR__.'/auth.php';
