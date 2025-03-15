<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthSanctumController;

Route::get('/', function () {
    return abort(404);
});

Route::get('reset-password-form/{token}/{email}', [AuthSanctumController::class, 'resetPasswordView'])->name('reset-password-form');
Route::get('teste', function (){
    return view('welcome');
});
