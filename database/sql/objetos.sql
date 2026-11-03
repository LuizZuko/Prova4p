-- database/sql/objetos.sql
SET search_path TO luiz_trabalho_bd;-- FUNCTION 1: média de avaliações de um jogo
CREATE OR REPLACE FUNCTION fn_media_avaliacoes(p_jogo_id INT)
RETURNS NUMERIC(3,2)
LANGUAGE sql
STABLE
AS $$
    SELECT COALESCE(ROUND(AVG(nota)::numeric, 2), 0.00)
    FROM avaliacoes
    WHERE jogo_id = p_jogo_id;
$$;-- FUNCTION 2: total gasto por usuário
CREATE OR REPLACE FUNCTION fn_total_gasto_usuario(p_usuario_id INT)
RETURNS NUMERIC(10,2)
LANGUAGE sql
STABLE
AS $$
    SELECT COALESCE(SUM(valor_total), 0.00)::numeric(10,2)
    FROM compras
    WHERE usuario_id = p_usuario_id;
$$;-- PROCEDURE 1: creditar carteira; valor deve ser positivo
CREATE OR REPLACE PROCEDURE sp_creditar_carteira(
    p_usuario_id INT,
    p_valor NUMERIC(10,2)
)
LANGUAGE plpgsql
AS $$
BEGIN
    IF p_valor <= 0 THEN
        RAISE EXCEPTION 'O valor do crédito deve ser positivo';
    END IF;
    UPDATE usuarios
    SET saldo_carteira = saldo_carteira + p_valor
    WHERE id_usuario = p_usuario_id;
    IF NOT FOUND THEN
        RAISE EXCEPTION 'Usuário não encontrado';
    END IF;
END;
$$;-- PROCEDURE 2: registrar uma compra
CREATE OR REPLACE PROCEDURE sp_registrar_compra(
    p_usuario_id INT,
    p_metodo_pagamento VARCHAR(30),
    p_valor_total NUMERIC(10,2)
)
LANGUAGE plpgsql
AS $$
BEGIN
    IF p_valor_total < 0 THEN
        RAISE EXCEPTION 'Valor total não pode ser negativo';
    END IF;
    INSERT INTO compras (usuario_id, metodo_pagamento, valor_total)
    VALUES (p_usuario_id, p_metodo_pagamento, p_valor_total);
END;
$$;-- Função auxiliar da trigger 1


CREATE OR REPLACE FUNCTION trg_recalcular_media_jogo()
RETURNS TRIGGER
LANGUAGE plpgsql
AS $$
DECLARE
    v_jogo_id INT;
BEGIN
    IF TG_OP = 'DELETE' THEN
        v_jogo_id := OLD.jogo_id;
    ELSE
        v_jogo_id := NEW.jogo_id;
    END IF;

    -- Recalcula a média do jogo atual
    UPDATE jogos
    SET avaliacao_media = (
        SELECT COALESCE(ROUND(AVG(nota)::numeric, 2), 0.00)
        FROM avaliacoes
        WHERE jogo_id = v_jogo_id
    )
    WHERE id_jogo = v_jogo_id;

    -- Se a avaliação foi transferida para outro jogo,
    -- também recalcula a média do jogo anterior.
    IF TG_OP = 'UPDATE'
       AND OLD.jogo_id IS DISTINCT FROM NEW.jogo_id THEN

        UPDATE jogos
        SET avaliacao_media = (
            SELECT COALESCE(ROUND(AVG(nota)::numeric, 2), 0.00)
            FROM avaliacoes
            WHERE jogo_id = OLD.jogo_id
        )
        WHERE id_jogo = OLD.jogo_id;

    END IF;

    RETURN NULL;
END;
$$;

DROP TRIGGER IF EXISTS tg_recalcular_media_avaliacao ON avaliacoes;
CREATE TRIGGER tg_recalcular_media_avaliacao
AFTER INSERT OR UPDATE OR DELETE ON avaliacoes
FOR EACH ROW EXECUTE FUNCTION trg_recalcular_media_jogo();-- Função auxiliar da trigger 2
CREATE OR REPLACE FUNCTION trg_validar_compra()
RETURNS TRIGGER
LANGUAGE plpgsql
AS $$
BEGIN
    IF NEW.valor_total < 0 THEN
        RAISE EXCEPTION 'O valor total da compra não pode ser negativo';
    END IF;
    IF NEW.metodo_pagamento IS NULL OR btrim(NEW.metodo_pagamento) = '' THEN
        RAISE EXCEPTION 'Informe o método de pagamento';
    END IF;
    RETURN NEW;
END;
$$;-- TRIGGER 2: valida campos de compra antes de gravar
DROP TRIGGER IF EXISTS tg_validar_compra ON compras;
CREATE TRIGGER tg_validar_compra
BEFORE INSERT OR UPDATE ON compras
FOR EACH ROW EXECUTE FUNCTION trg_validar_compra();