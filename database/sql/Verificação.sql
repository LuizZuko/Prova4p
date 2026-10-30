-- database/sql/verificacao.sql
-- Script de teste e validação das Funções, Procedures, Triggers e Índices

-- 1. Testar funções
SELECT luiz_trabalho_bd.fn_media_avaliacoes(1);
SELECT luiz_trabalho_bd.fn_total_gasto_usuario(1);

-- 2. Testar procedure de crédito na carteira
CALL luiz_trabalho_bd.sp_creditar_carteira(1, 10.00);

-- 3. Testar procedure de registro de compra
CALL luiz_trabalho_bd.sp_registrar_compra(1, 'teste', 10.00);

-- 4. Testar Trigger de média de avaliações
INSERT INTO luiz_trabalho_bd.avaliacoes (usuario_id, jogo_id, nota, comentario)
VALUES (1, 1, 5, 'Teste de trigger');

SELECT id_jogo, titulo, avaliacao_media
FROM luiz_trabalho_bd.jogos WHERE id_jogo = 1;

-- 5. Listar e verificar os índices criados
SELECT indexname, indexdef
FROM pg_indexes
WHERE schemaname = 'luiz_trabalho_bd'
ORDER BY indexname;