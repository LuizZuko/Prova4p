<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CarteiraService
{
    public function creditar(int $usuarioId, string $valor): void
    {
        DB::statement(
            'CALL luiz_trabalho_bd.sp_creditar_carteira(?, ?)',
            [$usuarioId, $valor]
        );
    }

    public function totalGasto(int $usuarioId): string
    {
        $resultado = DB::selectOne(
            'SELECT luiz_trabalho_bd.fn_total_gasto_usuario(?) AS total',
            [$usuarioId]
        );

        return (string) $resultado->total;
    }
}