<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\ProgressionController;


Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::post('login', [RegisterController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/progression/history', [ProgressionController::class, 'show'])->name('show');
    Route::post('/progression/add', [ProgressionController::class, 'store'])->name('store');
    Route::patch('/progression/update/{progression}', [ProgressionController::class, 'updateStatus']);
    Route::put('/progression/update/{progression}', [ProgressionController::class, 'update'])->name('update');
    Route::delete('/progression/delete/{progression}', [ProgressionController::class, 'destroy'])->name('delete');
    Route::post('logout', [RegisterController::class, 'logout'])->name('logout');
});