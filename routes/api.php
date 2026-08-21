<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\HelloDbController;
use Illuminate\Support\Facades\Route;

Route::get('/hello', HelloController::class);
Route::get('/hello-db', HelloDbController::class);
