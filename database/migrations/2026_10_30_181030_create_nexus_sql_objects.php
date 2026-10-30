<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Criar os Índices
        DB::statement('CREATE INDEX IF NOT EXISTS idx_jogos_categoria ON luiz_trabalho_bd.jogos (categoria_id)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_jogos_desenvolvedor ON luiz_trabalho_bd.jogos (desenvolvedor_id)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_compras_usuario_data ON luiz_trabalho_bd.compras (usuario_id, data_compra DESC)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_avaliacoes_jogo ON luiz_trabalho_bd.avaliacoes (jogo_id)');

        // 2. Importar e executar as Funções, Procedures e Triggers do arquivo SQL
        $pathObjetos = database_path('sql/objetos.sql');
        if (file_exists($pathObjetos)) {
            DB::unprepared(file_get_contents($pathObjetos));
        }
    }

    public function down(): void
    {
        // 1. Remover Triggers e suas funções auxiliares
        DB::unprepared('DROP TRIGGER IF EXISTS tg_validar_compra ON luiz_trabalho_bd.compras;');
        DB::unprepared('DROP FUNCTION IF EXISTS luiz_trabalho_bd.trg_validar_compra();');

        DB::unprepared('DROP TRIGGER IF EXISTS tg_recalcular_media_avaliacao ON luiz_trabalho_bd.avaliacoes;');
        DB::unprepared('DROP FUNCTION IF EXISTS luiz_trabalho_bd.trg_recalcular_media_jogo();');

        // 2. Remover Procedures
        DB::unprepared('DROP PROCEDURE IF EXISTS luiz_trabalho_bd.sp_registrar_compra(INT, VARCHAR, NUMERIC);');
        DB::unprepared('DROP PROCEDURE IF EXISTS luiz_trabalho_bd.sp_creditar_carteira(INT, NUMERIC);');

        // 3. Remover Funções
        DB::unprepared('DROP FUNCTION IF EXISTS luiz_trabalho_bd.fn_total_gasto_usuario(INT);');
        DB::unprepared('DROP FUNCTION IF EXISTS luiz_trabalho_bd.fn_media_avaliacoes(INT);');

        // 4. Remover Índices
        DB::statement('DROP INDEX IF EXISTS luiz_trabalho_bd.idx_jogos_categoria');
        DB::statement('DROP INDEX IF EXISTS luiz_trabalho_bd.idx_jogos_desenvolvedor');
        DB::statement('DROP INDEX IF EXISTS luiz_trabalho_bd.idx_compras_usuario_data');
        DB::statement('DROP INDEX IF EXISTS luiz_trabalho_bd.idx_avaliacoes_jogo');
    }
};