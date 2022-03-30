<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayersController;

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

    Route::get('players/create', [PlayersController::class, 'create'])->name('voyager.players.create');
    Route::post('players/store', [PlayersController::class, 'store'])->name('voyager.players.store');
    Route::get('players/{id}/edit', [PlayersController::class, 'edit'])->name('voyager.players.edit');
    Route::put('players/{id}', [PlayersController::class, 'update'])->name('voyager.players.update');
    Route::get('players/{id}/print', [PlayersController::class, 'print'])->name('players.print');

    Route::get('clubs/{id}/teams', [TeamController::class, 'teams']);
});

// Clear cache
Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');
    return redirect('/admin/profile')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');
