CREATE TABLE usuarios (
	id_usuario SERIAL NOT NULL,
	email VARCHAR(140) NOT NULL, -- nome diferente da modelagem, por conta de "user" ser palavra reservada
	nome VARCHAR(50) NOT NULL, 
	senha VARCHAR(16) NOT NULL,
	CONSTRAINT pk_usuario PRIMARY KEY (id_usuario)
);

INSERT INTO usuarios(email, nome, senha) VALUES('teste@email.com', 'Pedro João', 'senha12345');

SELECT * FROM usuarios;