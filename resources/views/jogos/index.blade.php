@extends('layouts.app')
@section('title', 'Catálogo | Nexus Games Studio')
@section('content')
<section class="page-head">
 <div>
 <p class="page-eyebrow">Nexus / Explorar</p>
 <h1>Seu próximo jogo começa aqui.</h1>
 <p class="page-description">Explore os jogos e gerencie o catálogo.</p>
 </div>
 <a class="button button-primary" href="{{ route('jogos.create') }}"> Cadastrar jogo</a>
</section>
<p class="catalog-summary">
 <strong>{{ $jogos->total() }}</strong> jogos cadastrados
 · Página {{ $jogos->currentPage() }}
</p>
<section class="catalog-grid" aria-label="Catálogo de jogos">
@forelse ($jogos as $jogo)
 <article class="game-card">
 <div class="game-art"><span class="game-art-label">NEXUS / GAME CATALOG</span></div>
 <div class="game-card-body">
 <div class="game-card-top">
 <h2>{{ $jogo->titulo }}</h2>
 <span class="category-pill">{{ $jogo->categoria?->nome_categoria ?? 'Sem categoria' }}</span>
 </div>
 <p class="game-developer">
 Desenvolvido por {{ $jogo->desenvolvedor?->nome_estudio ?? 'Não informado' }}
 </p>
 <p class="game-price">R$ {{ number_format((float)$jogo->preco,2,',','.') }}</p>
 <div class="game-card-actions">
 <a class="button button-primary" href="{{ route('jogos.show',$jogo) }}">Ver detalhes</a>
 <a class="button button-secondary" href="{{ route('jogos.edit',$jogo) }}">Editar</a>
 <form action="{{ route('jogos.destroy',$jogo) }}" method="POST"
 onsubmit="return confirm('Excluir este jogo?')">
 @csrf @method('DELETE')
 <button class="button button-danger" type="submit">Excluir</button>
 </form>
 </div>
 </div>
 </article>
@empty
 <div class="empty-state">
 <h2>Seu catálogo está começando.</h2>
 <p>Cadastre o primeiro jogo para preencher o catálogo.</p>
 <a class="button button-primary" href="{{ route('jogos.create') }}">Cadastrar primeiro jogo</a>
 </div>
@endforelse
</section>
@if ($jogos->hasPages())
<div class="pagination"><nav aria-label="Paginação">
 @if ($jogos->onFirstPage()) <span class="page-control">← Anterior</span>
 @else <a class="page-control" href="{{ $jogos->previousPageUrl() }}">← Anterior</a> @endif
 <span class="page-indicator">Página {{ $jogos->currentPage() }} de {{ $jogos->lastPage() }}</span>
 @if ($jogos->hasMorePages()) <a class="page-control" href="{{ $jogos->nextPageUrl() }}">Próxima →</a>
 @else <span class="page-control">Próxima →</span> @endif
</nav></div>
@endif
@endsection