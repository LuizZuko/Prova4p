
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#101522">

    <title>@yield('title', 'Nexus Games Studio')</title>

    <link rel="stylesheet" href="{{ asset('css/nexus.css') }}">

    <script>
        (function () {
            const temaSalvo = localStorage.getItem('nexus-tema');
            const tema = temaSalvo === 'claro' ? 'claro' : 'escuro';

            document.documentElement.setAttribute('data-theme', tema);
        })();
    </script>
</head>

<body>

<div class="site-shell">

    <header class="topbar">

        <a class="brand" href="{{ route('catalogo.index') }}">

            <span class="brand-mark">N</span>

            <span class="brand-copy">
                <strong>NEXUS GAMES</strong>
                <small>STUDIO</small>
            </span>

        </a>

        <nav class="main-nav" aria-label="Navegação principal">

            <a href="{{ route('catalogo.index') }}">
                Catálogo
            </a>

            <a href="{{ route('catalogo.create') }}">
                Cadastrar jogo
            </a>

        </nav>

        <div class="header-actions">

            <button
                type="button"
                class="theme-toggle"
                id="themeToggle"
                aria-label="Alternar tema"
                aria-pressed="false">

                <span id="themeIcon">☀️</span>
                <span id="themeText">Tema claro</span>

            </button>

            <span class="status-pill">
                <span class="status-dot"></span>
                Game catalog
            </span>

        </div>

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

<script>
    const botaoTema = document.getElementById('themeToggle');
    const iconeTema = document.getElementById('themeIcon');
    const textoTema = document.getElementById('themeText');

    function atualizarBotaoTema() {
        const temaAtual = document.documentElement.getAttribute('data-theme');
        const temaClaro = temaAtual === 'claro';

        iconeTema.textContent = temaClaro ? '🌙' : '☀️';
        textoTema.textContent = temaClaro ? 'Tema escuro' : 'Tema claro';

        botaoTema.setAttribute('aria-pressed', temaClaro ? 'true' : 'false');
    }

    atualizarBotaoTema();

    botaoTema.addEventListener('click', function () {
        const temaAtual = document.documentElement.getAttribute('data-theme');

        const novoTema = temaAtual === 'escuro' ? 'claro' : 'escuro';

        document.documentElement.setAttribute('data-theme', novoTema);

        localStorage.setItem('nexus-tema', novoTema);

        atualizarBotaoTema();
    });
</script>

</body>
</html>
