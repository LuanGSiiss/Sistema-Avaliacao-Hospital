BEGIN;

-- Setores
INSERT INTO setor(descricao) VALUES
	('Recepção'),
    ('Farmácia');

-- Dispositvos
INSERT INTO dispositivos(nome_dispositivo) VALUES
	('Padrão');

-- Perguntas
INSERT INTO perguntas(texto_pergunta, todos_setores) VALUES
	('O quanto você diria que essa hospital é bom para seu filho? *Pergunta Padrão', TRUE);

COMMIT;