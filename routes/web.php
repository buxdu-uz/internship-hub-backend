<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//oAuth2
Route::get('/auth/hemis', [AuthController::class, 'redirectToProvider'])->middleware('cors');
Route::get('/callback', [AuthController::class, 'handleCallback']);
