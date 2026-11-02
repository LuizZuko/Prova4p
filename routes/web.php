
<?php

use App\Http\Controllers\JogoController;
use Illuminate\Support\Facades\Route;

// Página inicial
Route::get('/', function () {
    return redirect()->route('catalogo.index');
});

// Rotas das páginas visuais
Route::resource('jogos', JogoController::class)
    ->names('catalogo');
