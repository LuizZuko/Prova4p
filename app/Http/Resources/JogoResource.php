<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JogoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_jogo,
            'titulo' => $this->titulo,
            'preco' => $this->preco,
            'data_lancamento' => $this->data_lancamento?->format('Y-m-d'),
            'avaliacao_media' => $this->avaliacao_media,
            'categoria' => [
                'id' => $this->categoria?->id_categoria,
                'nome' => $this->categoria?->nome_categoria,
            ],
            'desenvolvedor' => [
                'id' => $this->desenvolvedor?->id_desenvolvedor,
                'estudio' => $this->desenvolvedor?->nome_estudio,
            ],
        ];
    }
}