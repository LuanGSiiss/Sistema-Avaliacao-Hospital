
BEGIN;

CREATE TABLE setor (
	id_setor SERIAL NOT NULL,
	descricao VARCHAR(50) NOT NULL,
	CONSTRAINT pk_setor PRIMARY KEY (id_setor)
);

CREATE TABLE dispositivos (
	id_dispositivo SERIAL NOT NULL,
	nome_dispositivo VARCHAR(50) NOT NULL,
	status BOOLEAN NOT NULL DEFAULT TRUE,  -- Não está igual a modelagem, deve que ser atualizado
	CONSTRAINT pk_dispositivo PRIMARY KEY (id_dispositivo)
);

CREATE TABLE perguntas (
	id_pergunta SERIAL NOT NULL,
	texto_pergunta  VARCHAR(350) NOT NULL,
	status BOOLEAN NOT NULL DEFAULT TRUE,  -- Não está igual a modelagem, deve que ser atualizado
	CONSTRAINT pk_pergunta PRIMARY KEY (id_pergunta)
);

CREATE TABLE avaliacoes (
	id_avaliacao SERIAL NOT NULL,
	id_setor INTEGER NOT NULL,
	id_pergunta INTEGER NOT NULL,
	id_dispositivo INTEGER NOT NULL,
	resposta INTEGER NOT NULL,
	feedback_textual VARCHAR(350) NOT NULL,
	horario TIMESTAMP NOT NULL,
	CONSTRAINT pk_avaliacao PRIMARY KEY (id_avaliacao),
	CONSTRAINT fk_setor FOREIGN KEY (id_setor) 
		REFERENCES setor(id_setor),
	CONSTRAINT fk_pergunta FOREIGN KEY (id_pergunta) 
		REFERENCES perguntas(id_pergunta),
	CONSTRAINT fk_dispositivo FOREIGN KEY (id_dispositivo) 
		REFERENCES dispositivos(id_dispositivo)
);

CREATE TABLE usuarios (
	id_usuario SERIAL NOT NULL,
	usuario VARCHAR(50) NOT NULL, -- nome diferente da modelagem, por conta de "user" ser palavra reservada
	senha VARCHAR(50) NOT NULL,
	status BOOLEAN NOT NULL DEFAULT TRUE,  -- Não está igual a modelagem, deve que ser atualizado
	CONSTRAINT pk_usuario PRIMARY KEY (id_usuario)
);

CREATE TABLE pergunta_setor (
	id_pergunta INTEGER NOT NULL,
	id_setor INTEGER NOT NULL,
	CONSTRAINT pk_pergunta_setor PRIMARY KEY (id_pergunta, id_setor),
	CONSTRAINT fk_setor FOREIGN KEY (id_setor) 
		REFERENCES setor(id_setor),
	CONSTRAINT fk_pergunta FOREIGN KEY (id_pergunta) 
		REFERENCES perguntas(id_pergunta)
)
COMMIT;
