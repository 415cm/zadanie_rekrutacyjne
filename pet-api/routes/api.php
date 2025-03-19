<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::get('/pets', [PetController::class, 'index']);
Route::get('/pets/{id}', [PetController::class, 'show']);
Route::post('/pets', [PetController::class, 'store']);
Route::put('/pets/{id}', [PetController::class, 'update']);
Route::delete('/pets/{id}', [PetController::class, 'destroy']);
