
@extends('layouts.app')

@section('title', $jogo->titulo . ' | Nexus Games Studio')

@section('content')

<p class="page-eyebrow">
    Nexus / Catálogo / Detalhes
</p>

<section class="details-panel">

    <div class="details-heading">

        <span class="category-pill">
            {{ $jogo->categoria?->nome_categoria ?? 'Sem categoria' }}
        </span>

        <h1 style="margin-top: 16px">
            {{ $jogo->titulo }}
        </h1>

        <p class="page-description">
            Informações cadastradas deste título.
        </p>

    </div>

    <div class="details-content">

        @if ($jogo->capa)
            <div class="details-cover">
                <img
                    src="{{ asset('storage/' . $jogo->capa) }}"
                    alt="Capa do jogo {{ $jogo->titulo }}"
                >
            </div>
        @endif

        <div class="details-grid">

            <div class="detail-item">
                <span>Preço</span>
                <strong class="detail-price">
                    R$ {{ number_format((float) $jogo->preco, 2, ',', '.') }}
                </strong>
            </div>

            <div class="detail-item">
                <span>ID do jogo</span>
                <strong>#{{ $jogo->id_jogo }}</strong>
            </div>

            <div class="detail-item">
                <span>Desenvolvedor</span>
                <strong>
                    {{ $jogo->desenvolvedor?->nome_estudio ?? 'Não informado' }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Lançamento</span>
                <strong>
                    {{ $jogo->data_lancamento?->format('d/m/Y') ?? 'Não informado' }}
                </strong>
            </div>

            <div class="detail-item">
                <span>Avaliação média</span>
                <strong>
                    {{ number_format((float) $jogo->avaliacao_media, 2, ',', '.') }} / 5
                </strong>
            </div>

        </div>

        <div class="details-actions">

            <a class="button button-secondary"
               href="{{ route('catalogo.index') }}">
                Voltar
            </a>

            <a class="button button-primary"
               href="{{ route('catalogo.edit', $jogo) }}">
                Editar jogo
            </a>

        </div>

    </div>

</section>

@endsection
