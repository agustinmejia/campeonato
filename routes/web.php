<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\DelegatesController;
use App\Http\Controllers\GameController;

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

Route::get('login', function () {
    return redirect('admin/login');
})->name('login');

Route::get('/', function () {
    return redirect('admin');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('players', [PlayersController::class, 'index'])->name('voyager.players.index');
    Route::get('players/create', [PlayersController::class, 'create'])->name('voyager.players.create');
    Route::post('players/store', [PlayersController::class, 'store'])->name('voyager.players.store');
    Route::get('players/{id}/edit', [PlayersController::class, 'edit'])->name('voyager.players.edit');
    Route::put('players/{id}', [PlayersController::class, 'update'])->name('voyager.players.update');
    Route::get('players/{id}/transfers', [PlayersController::class, 'transfers'])->name('players.transfers');
    Route::post('players/{id}/transfers', [PlayersController::class, 'transfers_store'])->name('players.transfers.store');
    Route::get('players/transfers/{id}', [PlayersController::class, 'transfers_print'])->name('players.transfers.print');
    Route::get('players/{id}/print/{type}', [PlayersController::class, 'print'])->name('players.print');
    Route::post('players/{id}/transfers/delete', [PlayersController::class, 'transfers_delete'])->name('players.transfers.delete');

    Route::get('clubs/{id}/teams', [TeamController::class, 'teams']);

    Route::get('delegates/{id}/print', [DelegatesController::class, 'print'])->name('delegates.print');

    Route::get('game', [GameController::class, 'index']);
});

// Clear cache
Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');
    return redirect('/admin/profile')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');
