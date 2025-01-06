-- Inserindo dados basicos

BEGIN;

INSERT INTO setor(descricao) VALUES('Padrão');

INSERT INTO dispositivos(nome_dispositivo) VALUES('Padrão');

INSERT INTO perguntas(texto_pergunta) VALUES('O quanto você diria que essa hospital é bom para seu filho? *Pergunta Padrão');

COMMIT;

