CREATE DATABASE IF NOT EXISTS teste;

CREATE TABLE IF NOT EXISTS teste.usuarios(
	id SERIAL NOT NULL PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL,
	senha VARCHAR(32) NOT NULL
);

CREATE TABLE IF NOT EXISTS teste.elementos(
	id SERIAL NOT NULL PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	conteudo TEXT,
	usuario INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE
);

INSERT INTO teste.usuarios(
	nome, email, senha
) VALUES (
	'admin', 'admin@admin.ad', MD5('naosei1234*')
);