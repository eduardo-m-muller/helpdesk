-- ============================================================
-- banco.sql
-- Estrutura do banco do Helpdesk.
-- Para criar tudo do zero, rodar este arquivo no MySQL.
-- ============================================================

CREATE DATABASE IF NOT EXISTS db_helpdesk CHARACTER SET utf8mb4;
USE db_helpdesk;

-- Tabela onde ficam todos os chamados abertos
CREATE TABLE IF NOT EXISTS chamados (
    id           INT AUTO_INCREMENT PRIMARY KEY,           -- número do chamado
    nome_usuario VARCHAR(100) NOT NULL,                    -- quem abriu o chamado
    titulo       VARCHAR(255) NOT NULL,                    -- resumo do problema
    prioridade   VARCHAR(20)  NOT NULL,                    -- alta, media ou baixa
    descricao    TEXT         NOT NULL,                    -- detalhes do problema
    status       VARCHAR(20)  DEFAULT 'aberto',            -- começa sempre como "aberto"
    data_criacao TIMESTAMP    DEFAULT CURRENT_TIMESTAMP    -- data/hora preenchida automaticamente
);

-- Se a tabela já existia SEM a coluna nome_usuario, rodar só esta linha:
-- ALTER TABLE chamados ADD COLUMN nome_usuario VARCHAR(100) NOT NULL;
