<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;


Route::prefix('player')->group(function(){
    Route::get('/all', [PlayerController::class, 'all']);
    Route::get('/{id}', [PlayerController::class, 'find']);
    Route::post('/', [PlayerController::class, 'create']);
    Route::put('/{id}', [PlayerController::class, 'update']);
    Route::delete('/{id}', [PlayerController::class, 'delete']);
});

Route::prefix('team')->group(function(){
    Route::get('/all', [TeamController::class, 'all']);
    Route::get('/{id}/players', [TeamController::class, 'playersByTeamId']);
    Route::get('/{id}', [TeamController::class, 'find']);    
    Route::post('/players', [TeamController::class, 'persistTeams']);
    Route::put('/{id}', [TeamController::class, 'update']);
    Route::delete('/{id}', [TeamController::class, 'delete']);
});

Route::prefix('event')->group(function(){
    Route::get('/all', [EventController::class, 'all']);
    Route::get('/{id}', [EventController::class, 'find']);
    Route::post('/', [EventController::class, 'create']);
    Route::put('/{id}', [EventController::class, 'update']);
    Route::delete('/{id}', [EventController::class, 'delete']);
    Route::post('/{id}/presence/confirm', [EventController::class, 'presenceConfirm']);
    Route::post('/{id}/presence/cancel', [EventController::class, 'cancelAttenance']);
    Route::get('/drawteams/teamplayers/{playersByTeam}/event/{id}', [EventController::class, 'drawTeams']);
    Route::get('/{eventId}/players', [EventController::class, 'findPlayersByEventId']);
});
