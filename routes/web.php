<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\DelegatesController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\ChampionshipsCategoriesController;
use App\Http\Controllers\ReportsController;

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
    return view('welcome');
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
    Route::post('players/{id}/documents/store', [PlayersController::class, 'documents_store'])->name('voyager.players.documents.store');

    Route::get('clubs/{id}/teams', [TeamsController::class, 'teams']);

    Route::get('delegates/{id}/print', [DelegatesController::class, 'print'])->name('delegates.print');

    Route::resource('championshipscategories', ChampionshipsCategoriesController::class);
    Route::get('championshipscategories/list/ajax/{search?}', [ChampionshipsCategoriesController::class, 'list']);
    Route::post('championshipscategories/{id}/details/enable', [ChampionshipsCategoriesController::class, 'details_enable'])->name('championshipscategories.details.enable');
    Route::get('championshipscategories/game/{id}', [ChampionshipsCategoriesController::class, 'game'])->name('championshipscategories.game');
    Route::post('championshipscategories/game/{id}/goal', [ChampionshipsCategoriesController::class, 'game_goal'])->name('championshipscategories.game.goal');
    Route::post('championshipscategories/game/{id}/goal/delete', [ChampionshipsCategoriesController::class, 'game_goal_delete'])->name('championshipscategories.game.goal.delete');
    Route::post('championshipscategories/game/{id}/card', [ChampionshipsCategoriesController::class, 'game_card'])->name('championshipscategories.game.card');
    Route::post('championshipscategories/game/{id}/card/delete', [ChampionshipsCategoriesController::class, 'game_card_delete'])->name('championshipscategories.game.card.delete');
    Route::post('championshipscategories/game/{id}/change', [ChampionshipsCategoriesController::class, 'game_change'])->name('championshipscategories.game.change');
    Route::post('championshipscategories/game/{id}/finish', [ChampionshipsCategoriesController::class, 'game_finish'])->name('championshipscategories.game.finish');

    Route::get('reports/players', [ReportsController::class, 'players_index'])->name('reports.players.index');
    Route::post('reports/players/list', [ReportsController::class, 'players_list'])->name('reports.players.list');
});

// Clear cache
Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');
    return redirect('/admin/profile')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');
