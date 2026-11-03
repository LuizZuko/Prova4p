<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Categoria;
use App\Models\Desenvolvedor;
use App\Models\Jogo;
use App\Services\JogoService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class JogoController extends Controller
{
    public function __construct(
        private JogoService $service
    ) {}

    public function index(Request $request): View
    {
        $busca = $request->input('busca');
        $categoriaId = $request->input('categoria_id');

        $consulta = Jogo::with(['categoria', 'desenvolvedor']);

        if (!empty($busca)) {
            $consulta->where('titulo', 'ILIKE', '%' . $busca . '%');
        }

        if (!empty($categoriaId)) {
            $consulta->where('categoria_id', $categoriaId);
        }

        $jogos = $consulta
            ->orderBy('titulo')
            ->paginate(9)
            ->withQueryString();

        $categorias = Categoria::orderBy('nome_categoria')->get();

        return view('jogos.index', compact(
            'jogos',
            'categorias',
            'busca',
            'categoriaId'
        ));
    }

    public function create(): View
    {
        $categorias = Categoria::orderBy('nome_categoria')->get();
        $desenvolvedores = Desenvolvedor::orderBy('nome_estudio')->get();

        return view('jogos.create', compact(
            'categorias',
            'desenvolvedores'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
           'desenvolvedor_id' => [
    'required',
    'integer',
    Rule::exists('pgsql.luiz_trabalho_bd.desenvolvedores', 'id_desenvolvedor')
],

'categoria_id' => [
    'required',
    'integer',
    Rule::exists('pgsql.luiz_trabalho_bd.categorias', 'id_categoria')
],
            'preco' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99'
            ],
            'data_lancamento' => ['required', 'date'],
            'capa' => [
                'nullable',
                'image',
                'mimes:jpeg,png,webp',
                'max:5120'
            ],
        ]);

        if ($request->hasFile('capa')) {
            $dados['capa'] = $request->file('capa')
                ->store('capas', 'public');
        }

        $dados['avaliacao_media'] = 0;

        $this->service->criar($dados);

        return redirect()
            ->route('catalogo.index')
            ->with('sucesso', 'Jogo cadastrado com sucesso!');
    }

    public function show(Jogo $jogo): View
    {
        $jogo->load(['categoria', 'desenvolvedor']);

        return view('jogos.show', compact('jogo'));
    }

    public function edit(Jogo $jogo): View
    {
        $categorias = Categoria::orderBy('nome_categoria')->get();
        $desenvolvedores = Desenvolvedor::orderBy('nome_estudio')->get();

        return view('jogos.edit', compact(
            'jogo',
            'categorias',
            'desenvolvedores'
        ));
    }

    public function update(Request $request, Jogo $jogo): RedirectResponse
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
           'desenvolvedor_id' => [
    'required',
    'integer',
    Rule::exists('pgsql.luiz_trabalho_bd.desenvolvedores', 'id_desenvolvedor')
],

'categoria_id' => [
    'required',
    'integer',
    Rule::exists('pgsql.luiz_trabalho_bd.categorias', 'id_categoria')
],
            'preco' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99'
            ],
            'data_lancamento' => ['required', 'date'],
            'capa' => [
                'nullable',
                'image',
                'mimes:jpeg,png,webp',
                'max:5120'
            ],
        ]);

        if ($request->hasFile('capa')) {
            if ($jogo->capa) {
                Storage::disk('public')->delete($jogo->capa);
            }

            $dados['capa'] = $request->file('capa')
                ->store('capas', 'public');
        }

        $this->service->atualizar($jogo, $dados);

        return redirect()
            ->route('catalogo.index')
            ->with('sucesso', 'Jogo atualizado com sucesso!');
    }

    public function destroy(Jogo $jogo): RedirectResponse
    {
        if ($jogo->capa) {
            Storage::disk('public')->delete($jogo->capa);
        }

        $this->service->excluir($jogo);

        return redirect()
            ->route('catalogo.index')
            ->with('sucesso', 'Jogo excluído com sucesso!');
    }
}
