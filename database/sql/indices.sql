-- database/sql/indices.sql
CREATE INDEX IF NOT EXISTS idx_jogos_categoria
    ON luiz_trabalho_bd.jogos (categoria_id);
CREATE INDEX IF NOT EXISTS idx_jogos_desenvolvedor
    ON luiz_trabalho_bd.jogos (desenvolvedor_id);
CREATE INDEX IF NOT EXISTS idx_compras_usuario_data
    ON luiz_trabalho_bd.compras (usuario_id, data_compra DESC);
CREATE INDEX IF NOT EXISTS idx_avaliacoes_jogo
    ON luiz_trabalho_bd.avaliacoes (jogo_id);