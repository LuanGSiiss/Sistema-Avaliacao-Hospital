BEGIN;

-- Setores
INSERT INTO setores(descricao) VALUES
	('Recepção'),
    ('Farmácia');

-- Dispositvos
INSERT INTO dispositivos(codigo_identificador, nome) VALUES
	('001-001', 'Padrão');

-- Perguntas
INSERT INTO perguntas(texto_pergunta, todos_setores) VALUES
	('O quanto você diria que este hospital é bom para seu filho? *Pergunta Padrão', TRUE);

COMMIT;