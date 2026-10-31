<?php

use App\Http\Controllers\JogoController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('jogos.index'));

Route::resource('jogos', JogoController::class);