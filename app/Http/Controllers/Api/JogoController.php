<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JogoResource;
use App\Models\Categoria;
use App\Models\Desenvolvedor;
use App\Models\Jogo;
use App\Services\JogoService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class JogoController extends Controller
{
    public function __construct(private JogoService $service) {}

    public function index(): AnonymousResourceCollection
    {
        return JogoResource::collection($this->service->listar());
    }

    public function store(Request $request): JsonResponse
    {
        $dados = $this->validar($request);
        $dados['avaliacao_media'] = 0;

        $jogo = $this->service->criar($dados);
        $jogo->load(['categoria', 'desenvolvedor']);

        return (new JogoResource($jogo))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Jogo $jogo): JogoResource
    {
        $jogo->load(['categoria', 'desenvolvedor']);

        return new JogoResource($jogo);
    }

    public function update(Request $request, Jogo $jogo): JogoResource
    {
        $dados = $this->validar($request);

        $jogo = $this->service->atualizar($jogo, $dados);

        return new JogoResource($jogo);
    }

    public function destroy(Jogo $jogo): JsonResponse
    {
        $this->service->excluir($jogo);

        return response()->json([
            'mensagem' => 'Jogo excluído com sucesso.'
        ], 200);
    }

   private function validar(Request $request): array
{
    return $request->validate([
        'titulo' => ['required', 'string', 'max:120'],

        'desenvolvedor_id' => [
            'required',
            'integer',
            'exists:pgsql.luiz_trabalho_bd.desenvolvedores,id_desenvolvedor'
        ],

        'categoria_id' => [
            'required',
            'integer',
            'exists:pgsql.luiz_trabalho_bd.categorias,id_categoria'
        ],

        'preco' => [
            'required',
            'numeric',
            'min:0',
            'max:99999999.99'
        ],

        'data_lancamento' => ['required', 'date'],
    ]);
}
}