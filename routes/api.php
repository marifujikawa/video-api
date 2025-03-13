<?php

use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// Rotas para videos
Route::get('/videos', [VideoController::class, 'index']);
Route::get('/videos/{id}', [VideoController::class, 'show']);
Route::patch('/videos/{id}/increment/{field}', [VideoController::class, 'increment'])
    ->where('field', 'views|likes');