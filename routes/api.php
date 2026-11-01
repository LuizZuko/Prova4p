<?php

use App\Http\Controllers\Api\JogoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('jogos', JogoController::class);