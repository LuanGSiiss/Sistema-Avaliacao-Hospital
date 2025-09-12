
BEGIN;

CREATE TABLE setores (
	id_setor SERIAL NOT NULL,
	descricao VARCHAR(50) NOT NULL,
	status INTEGER NOT NULL DEFAULT 1 -- 0 - INATIVO; 1 - ATIVO 
);

ALTER TABLE setores ADD CONSTRAINT pk_setor PRIMARY KEY (id_setor);

--Analisar Melhor
CREATE TABLE dispositivos (
	id_dispositivo SERIAL NOT NULL,
	id_setor INTEGER NOT NULL,
	codigo_identificador VARCHAR(7) NOT NULL,
	nome VARCHAR(50) NOT NULL,
	status INTEGER NOT NULL DEFAULT 1 -- 0 - INATIVO; 1 - ATIVO
);

ALTER TABLE dispositivos ADD CONSTRAINT pk_dispositivo PRIMARY KEY (id_dispositivo);
ALTER TABLE dispositivos ADD CONSTRAINT fk_setor FOREIGN KEY (id_setor) 
	REFERENCES setores(id_setor);

--Aplicar mudanças nos dispositivos
ALTER TABLE dispositivos ADD COLUMN id_setor INTEGER NOT NULL DEFAULT 1;

ALTER TABLE dispositivos ADD CONSTRAINT fk_setor FOREIGN KEY (id_setor) 
	REFERENCES setores(id_setor);
--^^temporario

CREATE TABLE perguntas (
	id_pergunta SERIAL NOT NULL,
	texto_pergunta  VARCHAR(350) NOT NULL,
	todos_setores BOOLEAN NOT NULL,
	status INTEGER NOT NULL DEFAULT 1 -- 0 - INATIVO; 1 - ATIVO
);

ALTER TABLE perguntas ADD CONSTRAINT pk_pergunta PRIMARY KEY (id_pergunta);

CREATE TABLE avaliacoes (
	id_avaliacao SERIAL NOT NULL,
	id_setor INTEGER NOT NULL,
	id_pergunta INTEGER NOT NULL,
	id_dispositivo INTEGER NOT NULL,
	nota INTEGER NOT NULL,
	feedback_textual VARCHAR(350) NOT NULL,
	datahora_cadastro TIMESTAMP NOT NULL
);

ALTER TABLE avaliacoes ADD CONSTRAINT pk_avaliacao PRIMARY KEY (id_avaliacao);
ALTER TABLE avaliacoes ADD CONSTRAINT fk_setor FOREIGN KEY (id_setor) 
	REFERENCES setores(id_setor);
ALTER TABLE avaliacoes ADD CONSTRAINT fk_pergunta FOREIGN KEY (id_pergunta) 
	REFERENCES perguntas(id_pergunta);
ALTER TABLE avaliacoes ADD CONSTRAINT fk_dispositivo FOREIGN KEY (id_dispositivo) 
	REFERENCES dispositivos(id_dispositivo);

CREATE TABLE usuarios (
	id_usuario SERIAL NOT NULL,
	nome VARCHAR(50) NOT NULL,
	email varchar(50) NOT NULL,
	senha VARCHAR(50) NOT NULL,
	status INTEGER NOT NULL DEFAULT 1 -- 0 - INATIVO; 1 - ATIVO
);

ALTER TABLE usuarios ADD CONSTRAINT pk_usuario PRIMARY KEY (id_usuario);

CREATE TABLE pergunta_setor (
	id_pergunta INTEGER NOT NULL,
	id_setor INTEGER NOT NULL
);

ALTER TABLE pergunta_setor ADD CONSTRAINT pk_pergunta_setor PRIMARY KEY (id_pergunta, id_setor);
ALTER TABLE pergunta_setor ADD CONSTRAINT fk_setor FOREIGN KEY (id_setor) 
	REFERENCES setores(id_setor);
ALTER TABLE pergunta_setor ADD CONSTRAINT fk_pergunta FOREIGN KEY (id_pergunta) 
	REFERENCES perguntas(id_pergunta);

COMMIT;
