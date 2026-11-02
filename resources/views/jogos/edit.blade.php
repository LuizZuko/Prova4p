@extends('layouts.app')
@section('title', 'Editar jogo | Nexus Games Studio')
@section('content')
<div class="form-shell">
 <div class="page-head">
 <div><p class="page-eyebrow">Nexus / Editar registro</p><h1>Editar jogo</h1>
 <p class="page-description">Atualize {{ $jogo->titulo }}.</p></div>
 </div>
 <section class="form-panel">
 <div class="form-heading"><p class="page-eyebrow">ID: {{ $jogo->id_jogo }}</p>
 <h1>Revisar informações</h1></div>
 <div class="form-content">@include('jogos._form')</div>
 </section>
</div>
@endsection
