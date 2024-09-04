<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/register', [RegistrationController::class, 'register']);
Route::get('/link/{token}', [LinkController::class, 'show']);
Route::post('/link/{token}/generate', [LinkController::class, 'generateNewLink']);
Route::post('/link/{token}/deactivate', [LinkController::class, 'deactivateLink']);
Route::post('/link/{token}/lucky', [LinkController::class, 'imFeelingLucky']);
Route::get('/link/{token}/history', [LinkController::class, 'history']);
