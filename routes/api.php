<?php

use App\Http\Controllers\AuthSanctumController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminScope;
use Illuminate\Http\Request;
use App\Http\Middleware\UserScope;
use App\Http\Controllers\UserController;

Route::prefix('auth')->group(function() {
    Route::post('login', [AuthSanctumController::class, 'login']);
    Route::get('logout', [AuthSanctumController::class, 'logout'])->middleware('auth:sanctum');
    // Verificar o por quê na segunda requisição de logout (com o    usuário já deslogado), há um erro do framework devido há um redirecionamento mal sucedido
    Route::post('forgot-password', [AuthSanctumController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthSanctumController::class, 'resetPassword'])->name('reset-password');
    Route::get('reset-password-form', [AuthSanctumController::class, 'resetPasswordView']);
});

Route::post('auth-sanctum-preflight', [AuthSanctumController::class, 'preflight'])->middleware('auth:sanctum');

Route::get('dashboard-admin', function(Request $request){
        return 'dashboard';
})->name('dashboard')->middleware(['auth:sanctum', AdminScope::class]);

Route::get('dashboard-user', function(Request $request){
        return 'dashboard';
})->name('dashboard')->middleware(['auth:sanctum', UserScope::class]);

Route::prefix('user')->middleware(['auth:sanctum', AdminScope::class])->group(function() {
    Route::get('types', [UserController::class, 'getTypes']);
    Route::get('', [UserController::class, 'index']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
    Route::put('update-password/{id}', [UserController::class, 'updatePassword']);
});
