
@extends('layouts.app')

@section('title', 'Catálogo | Nexus Games Studio')

@section('content')

<section class="page-head">

    <div>
        <p class="page-eyebrow">Nexus / Explorar</p>

        <h1>Seu próximo jogo começa aqui.</h1>

        <p class="page-description">
            Explore os jogos e encontre seu próximo favorito.
        </p>
    </div>

    <a class="button button-primary"
       href="{{ route('catalogo.create') }}">
        Cadastrar jogo
    </a>

</section>

<!-- FILTRO DE JOGOS -->

<section class="filter-panel">

    <div class="filter-heading">
        <div>
            <p class="page-eyebrow">Nexus / Pesquisa</p>
            <h2>Encontre seu jogo</h2>
        </div>
    </div>

    <form action="{{ route('catalogo.index') }}"
          method="GET"
          class="filter-form">

        <div class="field">

            <label for="busca">Nome do jogo</label>

            <input
                type="search"
                id="busca"
                name="busca"
                value="{{ $busca ?? '' }}"
                placeholder="Digite o nome do jogo..."
            >

        </div>

        <div class="field">

            <label for="categoria_id">Categoria</label>

            <select id="categoria_id" name="categoria_id">

                <option value="">Todas as categorias</option>

                @foreach ($categorias as $categoria)

                    <option
                        value="{{ $categoria->id_categoria }}"
                        @selected(($categoriaId ?? '') == $categoria->id_categoria)
                    >
                        {{ $categoria->nome_categoria }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="filter-actions">

            <button type="submit" class="button button-primary">
                <span>Pesquisar</span>
            </button>

            <a href="{{ route('catalogo.index') }}"
               class="button button-secondary">
                Limpar filtros
            </a>

        </div>

    </form>

</section>

<!-- RESUMO DO CATÁLOGO -->

<p class="catalog-summary">

    <strong>{{ $jogos->total() }}</strong>

    jogos encontrados

    @if (!empty($busca))
        · Pesquisa: "{{ $busca }}"
    @endif

</p>

<!-- LISTAGEM DE JOGOS -->

<section class="catalog-grid" aria-label="Catálogo de jogos">

    @forelse ($jogos as $jogo)

        <article class="game-card">

           <div class="game-art">
    @if ($jogo->capa)
        <img
            src="{{ asset('storage/' . $jogo->capa) }}"
            alt="Capa do jogo {{ $jogo->titulo }}"
        >
    @else
        <span class="game-art-label">
            NEXUS / GAME CATALOG
        </span>
    @endif
</div>

            <div class="game-card-body">

                <div class="game-card-top">

                    <h2>{{ $jogo->titulo }}</h2>

                    <span class="category-pill">
                        {{ $jogo->categoria?->nome_categoria ?? 'Sem categoria' }}
                    </span>

                </div>

                <p class="game-developer">
                    Desenvolvido por
                    {{ $jogo->desenvolvedor?->nome_estudio ?? 'Não informado' }}
                </p>

                <p class="game-price">
                    R$ {{ number_format((float) $jogo->preco, 2, ',', '.') }}
                </p>

                <div class="game-card-actions">

                    <a class="button button-primary"
                       href="{{ route('catalogo.show', $jogo) }}">
                        Ver detalhes
                    </a>

                    <a class="button button-secondary"
                       href="{{ route('catalogo.edit', $jogo) }}">
                        Editar
                    </a>

                    <form action="{{ route('catalogo.destroy', $jogo) }}"
                          method="POST"
                          onsubmit="return confirm('Excluir este jogo?')">

                        @csrf
                        @method('DELETE')

                        <button class="button button-danger" type="submit">
                            Excluir
                        </button>

                    </form>

                </div>

            </div>

        </article>

    @empty

        <div class="empty-state">

            <h2>Nenhum jogo encontrado.</h2>

            <p>
                Tente pesquisar por outro nome ou selecionar outra categoria.
            </p>

            <a class="button button-secondary"
               href="{{ route('catalogo.index') }}">
                Limpar filtros
            </a>

        </div>

    @endforelse

</section>

<!-- PAGINAÇÃO -->

@if ($jogos->hasPages())

    <div class="pagination">

        <nav aria-label="Paginação">

            @if ($jogos->onFirstPage())

                <span class="page-control">← Anterior</span>

            @else

                <a class="page-control"
                   href="{{ $jogos->previousPageUrl() }}">
                    ← Anterior
                </a>

            @endif

            <span class="page-indicator">
                Página {{ $jogos->currentPage() }}
                de {{ $jogos->lastPage() }}
            </span>

            @if ($jogos->hasMorePages())

                <a class="page-control"
                   href="{{ $jogos->nextPageUrl() }}">
                    Próxima →
                </a>

            @else

                <span class="page-control">Próxima →</span>

            @endif

        </nav>

    </div>

@endif

@endsection
