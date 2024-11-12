<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('dashboard', function(Request $request){
        return 'dashboard';
})->name('dashboard')->middleware('auth:sanctum');
