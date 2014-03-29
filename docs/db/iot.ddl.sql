--
-- schema iot
--

CREATE SCHEMA iot;


CREATE TABLE iot.departamento (
	id_departamento bigserial PRIMARY KEY,
	nome_departamento varchar(30) NOT NULL UNIQUE,
	sigla_departamento varchar(5) NOT NULL UNIQUE,
	id_campus integer NOT NULL REFERENCES campus(id_campus)
);


CREATE TABLE iot.setor (
	id_setor bigserial PRIMARY KEY,
	nome_setor varchar(30) NOT NULL UNIQUE,
	id_departamento bigint NOT NULL REFERENCES iot.departamento(id_departamento),
	sigla_setor varchar(5) NOT NULL UNIQUE
);


CREATE TABLE iot.tipo_notificacao (
	id_tipo_notificacao serial PRIMARY KEY,
	tipo_notificacao varchar(20) NOT NULL UNIQUE,
	TEMPLATE text NOT NULL
);


CREATE TABLE iot.notificacao (
	id_notificacao bigserial PRIMARY KEY,
	notificacao varchar(140) NOT NULL, -- json string, must match tipo_notificacao.template
	id_tipo_notificacao integer NOT NULL REFERENCES iot.tipo_notificacao(id_tipo_notificacao),
	data_notificacao TIMESTAMP NOT NULL DEFAULT now(),
	id_usuario bigint NOT NULL -- pode ser servidor ou aluno
);

CREATE TABLE iot.notificacao_setor (
	id_notificacao bigint NOT NULL REFERENCES iot.notificacao(id_notificacao),
	id_setor bigint NOT NULL REFERENCES iot.setor(id_setor),
	PRIMARY KEY (id_notificacao, id_setor)
);

--
-- SELECT substring(nome from '^.+?\s')
-- seleciona a partir do início, qualquer caractere até um espaço
-- ou seja, o primeiro nome. :)

CREATE VIEW usuario (id, nome, nome_breve, senha)
AS
SELECT siape, nome, trim(substring(nome FROM '^.+?\s')) AS nome_breve, senha
FROM servidor s
INNER JOIN pessoa p ON s.cpf = p.cpf;
