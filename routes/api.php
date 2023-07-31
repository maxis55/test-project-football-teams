<?php

use App\Http\Controllers\Api\LeagueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function () {
    Route::resource('leagues', LeagueController::class)
        ->except(['edit', 'update', 'create', 'destroy']);
    Route::get('leagues/{league}/get-results',
        [LeagueController::class, 'getResults'])
        ->name('leagues.get-results');

    Route::get('leagues/{league}/get-all-match-results',
        [LeagueController::class, 'getAllMatchResults'])
        ->name('leagues.get-all-match-results');

    Route::post('leagues/{league}/run-next-week', [LeagueController::class, 'runNextWeek'])
        ->name('leagues.run-next-week');
    Route::post('leagues/{league}/play-all', [LeagueController::class, 'playAll'])
        ->name('leagues.play-all');

    Route::patch('matches/{match}/update-results', [\App\Http\Controllers\Api\MatchController::class, 'updateResults'])
        ->name('matches.update-results');
});


