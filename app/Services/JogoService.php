<?php

namespace App\Services;

use App\Models\Jogo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class JogoService
{
    public function listar(int $porPagina = 12): LengthAwarePaginator
    {
        return Jogo::with(['categoria', 'desenvolvedor'])
            ->orderBy('titulo')
            ->paginate($porPagina);
    }

    public function encontrar(int $id): Jogo
    {
        return Jogo::with(['categoria', 'desenvolvedor'])
            ->findOrFail($id);
    }

    public function criar(array $dados): Jogo
    {
        return Jogo::create($dados);
    }

    public function atualizar(Jogo $jogo, array $dados): Jogo
    {
        $jogo->update($dados);

        return $jogo->fresh(['categoria', 'desenvolvedor']);
    }

    public function excluir(Jogo $jogo): void
    {
        $jogo->delete();
    }
}