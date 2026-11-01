<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Services\CarteiraService;
use Illuminate\Http\Request;

class CarteiraController extends Controller
{
    public function creditar(
        Request $request,
        Usuario $usuario,
        CarteiraService $service
    ) {
        $dados = $request->validate([
            'valor' => ['required', 'numeric', 'gt:0', 'max:1000000'],
        ]);

        $service->creditar($usuario->id_usuario, (string) $dados['valor']);

        return response()->json([
            'mensagem' => 'Crédito realizado com sucesso.'
        ], 200);
    }

    public function totalGasto(Usuario $usuario, CarteiraService $service)
    {
        return response()->json([
            'usuario_id' => $usuario->id_usuario,
            'total_gasto' => $service->totalGasto($usuario->id_usuario),
        ]);
    }
}