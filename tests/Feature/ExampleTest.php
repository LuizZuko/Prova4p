<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\CreatesTestDatabase;

class ExampleTest extends TestCase
{
    use CreatesTestDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->criarBancoDeTestes();
    }

    public function test_a_pagina_inicial_redireciona_para_o_catalogo(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('catalogo.index'));
    }

    public function test_o_catalogo_abre_com_sucesso(): void
    {
        $response = $this->get(route('catalogo.index'));

        $response->assertStatus(200);
        $response->assertSee('Encontre seu jogo');
    }

    public function test_a_api_retorna_a_lista_de_jogos_em_json(): void
{
    $this->criarJogoDeTeste();

    $response = $this->getJson('/api/jogos');

    $response->assertOk()
        ->assertJsonFragment([
            'titulo' => 'Jogo de Teste',
        ]);
}

    public function test_a_api_retorna_os_detalhes_de_um_jogo(): void
{
    $jogoId = $this->criarJogoDeTeste();

    $response = $this->getJson("/api/jogos/{$jogoId}");

    $response->assertOk()
        ->assertJsonPath('data.titulo', 'Jogo de Teste')
        ->assertJsonPath('data.categoria.nome', 'Aventura')
        ->assertJsonPath('data.desenvolvedor.estudio', 'Nexus Studio');
}
}