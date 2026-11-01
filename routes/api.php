<?php

use App\Http\Controllers\Api\CarteiraController;
use App\Http\Controllers\Api\JogoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('jogos', JogoController::class);

Route::post(
    '/usuarios/{usuario}/carteira/creditos',
    [CarteiraController::class, 'creditar']
);

Route::get(
    '/usuarios/{usuario}/total-gasto',
    [CarteiraController::class, 'totalGasto']
);