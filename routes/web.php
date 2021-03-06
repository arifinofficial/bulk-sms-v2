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

Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
    return redirect('/dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::resource('group-management', App\Http\Controllers\GroupController::class)->except(['show']);
    Route::resource('broadcast-manager', App\Http\Controllers\BroadcastController::class)->except(['show']);
    Route::resource('broadcast-history', App\Http\Controllers\BroadcastHistoryController::class);

    Route::group(['prefix' => 'data-grid', 'as' => 'data-grid.'], function () {
        Route::get('group-management', [App\Http\Controllers\GroupController::class, 'dataGrid'])->name('group-management');
        Route::get('member/{group_id}', [App\Http\Controllers\MemberController::class, 'dataGrid'])->name('member');
        Route::get('broadcast-history', [App\Http\Controllers\BroadcastController::class, 'dataGrid'])->name('broadcast-history');
        Route::get('broadcast-history-detail/{broadcast_id}', [App\Http\Controllers\BroadcastHistoryController::class, 'dataGrid'])->name('broadcast-history-detail');
    });
});

Route::get('receive/dr-url/{broadcast_id}/{key}', [App\Http\Controllers\DrUrlController::class, 'drUrl']);
