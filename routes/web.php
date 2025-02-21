<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SerieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/movies/{language}', [MovieController::class, 'index']);
Route::get('/series/{language}', [SerieController::class, 'index']);
Route::get('/genres', [GenreController::class, 'index']);
