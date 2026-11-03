<?php

namespace Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait CreatesTestDatabase
{
    protected function criarBancoDeTestes(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('id_categoria');
            $table->string('nome_categoria', 100);
            $table->text('descricao')->nullable();
        });

        Schema::create('desenvolvedores', function (Blueprint $table) {
            $table->increments('id_desenvolvedor');
            $table->string('nome_estudio');
            $table->string('pais')->nullable();
            $table->date('ano_fundacao')->nullable();
            $table->string('email_contato')->nullable();
        });

        Schema::create('jogos', function (Blueprint $table) {
            $table->increments('id_jogo');
            $table->string('titulo', 120);
            $table->unsignedInteger('desenvolvedor_id');
            $table->unsignedInteger('categoria_id');
            $table->decimal('preco', 10, 2);
            $table->date('data_lancamento');
            $table->decimal('avaliacao_media', 3, 2)->default(0);

            $table->foreign('desenvolvedor_id')
                ->references('id_desenvolvedor')
                ->on('desenvolvedores');

            $table->foreign('categoria_id')
                ->references('id_categoria')
                ->on('categorias');
        });
    }

    protected function criarJogoDeTeste(): int
{
    $categoriaId = \Illuminate\Support\Facades\DB::table('categorias')
        ->insertGetId([
            'nome_categoria' => 'Aventura',
            'descricao' => 'Jogos de aventura',
        ], 'id_categoria');

    $desenvolvedorId = \Illuminate\Support\Facades\DB::table('desenvolvedores')
        ->insertGetId([
            'nome_estudio' => 'Nexus Studio',
            'pais' => 'Brasil',
            'ano_fundacao' => '2020-01-01',
            'email_contato' => 'nexus@email.com',
        ], 'id_desenvolvedor');

    return \Illuminate\Support\Facades\DB::table('jogos')
        ->insertGetId([
            'titulo' => 'Jogo de Teste',
            'desenvolvedor_id' => $desenvolvedorId,
            'categoria_id' => $categoriaId,
            'preco' => 59.90,
            'data_lancamento' => '2025-01-01',
            'avaliacao_media' => 0,
        ], 'id_jogo');
}
}