<?php

use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// Rotas para videos
Route::get('/videos', [VideoController::class, 'index']);
Route::get('/videos/{video}', [VideoController::class, 'show']);
Route::patch('/videos/{video}', [VideoController::class, 'update']);
Route::post('/videos/{video}/like', [VideoController::class, 'incrementLikes']);