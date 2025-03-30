-- Inserindo dados basicos

BEGIN;

INSERT INTO setor(descricao) VALUES('Geral');

INSERT INTO dispositivos(nome_dispositivo) VALUES('Padrão');

INSERT INTO perguntas(texto_pergunta) VALUES('O quanto você diria que essa hospital é bom para seu filho? *Pergunta Padrão');

INSERT INTO pergunta_setor(id_pergunta, id_setor) VALUES(1, 1);

COMMIT;

