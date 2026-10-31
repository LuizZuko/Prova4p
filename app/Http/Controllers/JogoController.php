<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Desenvolvedor;
use App\Models\Jogo;
use App\Services\JogoService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class JogoController extends Controller
{
    public function __construct(private JogoService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $jogos = $this->service->listar();

        return view('jogos.index', compact('jogos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categorias = Categoria::orderBy('nome_categoria')->get();
        $desenvolvedores = Desenvolvedor::orderBy('nome_estudio')->get();

        return view('jogos.create', compact('categorias', 'desenvolvedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
            'desenvolvedor_id' => [
                'required', 'integer',
                'exists:luiz_trabalho_bd.desenvolvedores,id_desenvolvedor'
            ],
            'categoria_id' => [
                'required', 'integer',
                'exists:luiz_trabalho_bd.categorias,id_categoria'
            ],
            'preco' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'data_lancamento' => ['required', 'date'],
        ]);

        $dados['avaliacao_media'] = 0;

        $this->service->criar($dados);

        return redirect()->route('jogos.index')
            ->with('sucesso', 'Jogo cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jogo $jogo): View
    {
        $jogo->load(['categoria', 'desenvolvedor']);

        return view('jogos.show', compact('jogo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jogo $jogo): View
    {
        $categorias = Categoria::orderBy('nome_categoria')->get();
        $desenvolvedores = Desenvolvedor::orderBy('nome_estudio')->get();

        return view('jogos.edit', compact('jogo', 'categorias', 'desenvolvedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jogo $jogo): RedirectResponse
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
            'desenvolvedor_id' => [
                'required', 'integer',
                'exists:luiz_trabalho_bd.desenvolvedores,id_desenvolvedor'
            ],
            'categoria_id' => [
                'required', 'integer',
                'exists:luiz_trabalho_bd.categorias,id_categoria'
            ],
            'preco' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'data_lancamento' => ['required', 'date'],
        ]);

        $this->service->atualizar($jogo, $dados);

        return redirect()->route('jogos.index')
            ->with('sucesso', 'Jogo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jogo $jogo): RedirectResponse
    {
        $this->service->excluir($jogo);

        return redirect()->route('jogos.index')
            ->with('sucesso', 'Jogo excluído com sucesso!');
    }
}