
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tabelas = [
            'categorias',
            'desenvolvedores',
            'usuarios',
            'jogos',
            'compras',
            'itens_compra',
            'avaliacoes',
        ];

        // Verifica quais tabelas já existem.
        $existentes = array_filter(
            $tabelas,
            fn ($tabela) => Schema::hasTable($tabela)
        );

        // Se todas existem, não altera nem recria nada.
        if (count($existentes) === count($tabelas)) {
            return;
        }

        // Se apenas algumas existem, interrompe a execução.
        if (count($existentes) > 0) {
            throw new RuntimeException(
                'Estrutura parcial detectada. Nenhuma tabela foi criada.'
            );
        }

        // 1. CATEGORIAS
        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('id_categoria');
            $table->string('nome_categoria', 50)->unique();
            $table->text('descricao')->nullable();
        });

        // 2. DESENVOLVEDORES
        Schema::create('desenvolvedores', function (Blueprint $table) {
            $table->increments('id_desenvolvedor');
            $table->string('nome_estudio', 100);
            $table->string('pais', 50);
            $table->date('ano_fundacao');
            $table->string('email_contato', 100)->unique();
        });

        // 3. USUARIOS
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->string('nome', 100);
            $table->string('email', 100)->unique();
            $table->timestamp('data_cadastro')
                ->useCurrent()
                ->nullable();
            $table->string('pais', 50);
            $table->decimal('saldo_carteira', 10, 2)
                ->default(0)
                ->nullable();
        });

        // 4. JOGOS
        Schema::create('jogos', function (Blueprint $table) {
            $table->increments('id_jogo');
            $table->string('titulo', 120);
            $table->integer('desenvolvedor_id')->nullable();
            $table->integer('categoria_id')->nullable();
            $table->decimal('preco', 10, 2);
            $table->date('data_lancamento');
            $table->decimal('avaliacao_media', 3, 2)
                ->default(0)
                ->nullable();

            // Coluna adicionada posteriormente ao projeto.
            $table->string('capa', 255)->nullable();

            $table->foreign('desenvolvedor_id')
                ->references('id_desenvolvedor')
                ->on('desenvolvedores')
                ->onDelete('cascade');

            $table->foreign('categoria_id')
                ->references('id_categoria')
                ->on('categorias')
                ->onDelete('restrict');
        });

        // 5. COMPRAS
        Schema::create('compras', function (Blueprint $table) {
            $table->increments('id_compra');
            $table->integer('usuario_id')->nullable();
            $table->timestamp('data_compra')->useCurrent();
            $table->string('metodo_pagamento', 30);
            $table->decimal('valor_total', 10, 2);

            $table->foreign('usuario_id')
                ->references('id_usuario')
                ->on('usuarios')
                ->onDelete('cascade');
        });

        // 6. ITENS_COMPRA
        Schema::create('itens_compra', function (Blueprint $table) {
            $table->increments('id_item');
            $table->integer('compra_id')->nullable();
            $table->integer('jogo_id')->nullable();
            $table->decimal('preco_unitario', 10, 2);

            $table->foreign('compra_id')
                ->references('id_compra')
                ->on('compras')
                ->onDelete('cascade');

            $table->foreign('jogo_id')
                ->references('id_jogo')
                ->on('jogos')
                ->onDelete('cascade');
        });

        // 7. AVALIACOES
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->increments('id_avaliacao');
            $table->integer('usuario_id')->nullable();
            $table->integer('jogo_id')->nullable();
            $table->integer('nota')->nullable();
            $table->text('comentario')->nullable();
            $table->date('data_avaliacao')
                ->useCurrent()
                ->nullable();

            $table->foreign('usuario_id')
                ->references('id_usuario')
                ->on('usuarios')
                ->onDelete('cascade');

            $table->foreign('jogo_id')
                ->references('id_jogo')
                ->on('jogos')
                ->onDelete('cascade');
        });

        // RESTRICOES CHECK

        DB::statement(
            'ALTER TABLE jogos
             ADD CONSTRAINT chk_jogos_preco
             CHECK (preco >= 0)'
        );

        DB::statement(
            'ALTER TABLE avaliacoes
             ADD CONSTRAINT chk_avaliacoes_nota
             CHECK (nota BETWEEN 1 AND 5)'
        );

        DB::statement(
            'ALTER TABLE compras
             ADD CONSTRAINT chk_compras_valor
             CHECK (valor_total >= 0)'
        );

        DB::statement(
            'ALTER TABLE itens_compra
             ADD CONSTRAINT chk_itens_preco
             CHECK (preco_unitario >= 0)'
        );

        DB::statement(
            'ALTER TABLE usuarios
             ADD CONSTRAINT chk_usuarios_saldo
             CHECK (saldo_carteira >= 0)'
        );
    }

    public function down(): void
    {
        // Intencionalmente vazio.
        // Protege as tabelas e os dados existentes no Neon.
    }
};
