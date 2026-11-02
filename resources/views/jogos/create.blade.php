@extends('layouts.app')
@section('title', 'Cadastrar jogo | Nexus Games Studio')
@section('content')
<div class="form-shell">
 <div class="page-head">
 <div><p class="page-eyebrow">Nexus / Novo registro</p><h1>Adicionar jogo</h1>
 <p class="page-description">Preencha os dados do novo título.</p></div>
 </div>
 <section class="form-panel">
 <div class="form-heading"><p class="page-eyebrow">Catálogo</p>
 <h1>Detalhes do jogo</h1></div>
 <div class="form-content">@include('jogos._form')</div>
 </section>
</div>
@endsection