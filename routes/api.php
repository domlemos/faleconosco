<?php

use App\Http\Controllers\AuthSanctumController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckScope;

Route::prefix('auth')->group(function() {
    Route::post('login', [AuthSanctumController::class, 'login']);
    Route::get('logout', [AuthSanctumController::class, 'logout'])->middleware('auth:sanctum');
    // Verificar o por quê na segunda requisição de logout (com o usuário já deslogado), há um erro do framework devido há um redirecionamento mal sucedido
    Route::post('forgot-password', [AuthSanctumController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthSanctumController::class, 'resetPassword']);
});

Route::get('dashboard', function(Request $request){
        return 'dashboard';
})->name('dashboard')->middleware('auth:sanctum');
