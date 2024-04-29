<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/books',BookController::class)->middleware('auth:sanctum');

Route::post('/sanctum/token',[RegisteredUserController::class, 'getToken']);
