<!DOCTYPE html>
<html lang="pt-BR">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="theme-color" content="#101522">
 <title>@yield('title', 'Nexus Games Studio')</title>
 <link rel="stylesheet" href="{{ asset('css/nexus.css') }}">
</head>
<body>
<div class="site-shell">
 <header class="topbar">
 <a class="brand" href="{{ route('jogos.index') }}">
 <span class="brand-mark">N</span>
 <span class="brand-copy">
 <strong>NEXUS GAMES</strong><small>STUDIO</small>
 </span>
 </a>
 <nav class="main-nav" aria-label="Navegação principal">
 <a href="{{ route('jogos.index') }}">Catálogo</a>
 <a href="{{ route('jogos.create') }}">Cadastrar jogo</a>
 </nav>
 <span class="status-pill"><span class="status-dot"></span> Game catalog</span>
 </header>
 <main class="container">
 @if (session('sucesso'))
 <div class="alert alert-success" role="status">
 ✓ {{ session('sucesso') }}
 </div>
 @endif
 @if ($errors->any())
 <div class="alert alert-error" role="alert">
 Existem campos que precisam ser corrigidos.
 Confira as mensagens abaixo dos campos.
 </div>
 @endif
 @yield('content')
 </main>
 <footer class="footer">
 <span>NEXUS GAMES STUDIO</span>
 <span>Projeto acadêmico · Catálogo de jogos</span>
 </footer>
</div>
</body>
</html>