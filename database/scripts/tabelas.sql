
CREATE TABLE Usuario (
	id_usuario int PRIMARY KEY auto_increment not null,
	nome varchar(60) not null,
	email varchar(60) not null unique,
	permissao char(1) not null,
	ativo boolean not null default 1,
	created_at timestamp not null,
	updated_at timestamp null
);

CREATE TABLE AcademicoTrabalho (
	id_academico_trabalho int PRIMARY KEY auto_increment not null,
	id_trabalho int not null,
	id_academico int not null,
	created_at timestamp not null,
	updated_at timestamp null
);

CREATE TABLE BancaAvaliacao (
	id_bancaavaliacao int PRIMARY KEY auto_increment not null,
	papel varchar(1) not null,
	id_etapa_trabalho int not null,
	id_academico_trabalho int not null,
	id_membrobanca int not null,
	created_at timestamp not null,
	updated_at timestamp null,
	FOREIGN KEY(id_academico_trabalho) REFERENCES AcademicoTrabalho (id_academico_trabalho)
);

CREATE TABLE Academico (
	id_academico int PRIMARY KEY auto_increment not null,
	ra varchar(8) unique not null,
	id_usuario int not null,
	id_curso int not null,
	created_at timestamp not null,
	updated_at timestamp null,
	FOREIGN KEY(id_usuario) REFERENCES Usuario (id_usuario)
);

CREATE TABLE EtapaAno (
	id_etapaano int PRIMARY KEY auto_increment not null,
	titulo varchar(100) not null,
	data_inicial datetime not null,
	data_final datetime null,
	status boolean not null default 1,
	id_etapa int not null,
	created_at timestamp not null,
	updated_at timestamp null
);

CREATE TABLE Departamento (
	id_departamento int PRIMARY KEY auto_increment not null,
	nome varchar(40) not null unique,
	sigla varchar(10) not null unique,
	id_instituicao int not null,
	created_at timestamp not null,
	updated_at timestamp null
);

CREATE TABLE Curso (
	id_curso int PRIMARY KEY auto_increment not null,
	nome varchar(50) not null unique,
	id_departamento int not null,
	created_at timestamp not null,
	updated_at timestamp null,
	FOREIGN KEY(id_departamento) REFERENCES Departamento (id_departamento)
);

CREATE TABLE EtapaTrabalho (
	id_etapa_trabalho int PRIMARY KEY auto_increment not null,
	excecao boolean not null default 0 ,
	id_trabalho int null,
	id_etapaano int not null,
	created_at timestamp not null,
	updated_at timestamp null,
	FOREIGN KEY(id_etapaano) REFERENCES EtapaAno (id_etapaano)
);

CREATE TABLE Trabalho (
	id_trabalho int PRIMARY KEY auto_increment not null,
	titulo varchar(255) not null unique,
	aprovado boolean not null default 0,
	periodo int not null,
	ano varchar(4) not null,
	id_orientador int not null,
	id_coorientador int null,
	created_at timestamp not null,
	updated_at timestamp null
);

CREATE TABLE MembroBanca (
	id_membrobanca int PRIMARY KEY auto_increment not null,
	id_usuario int not null,
	id_departamento int not null,
	created_at timestamp not null,
	updated_at timestamp null,
	FOREIGN KEY(id_usuario) REFERENCES Usuario (id_usuario),
	FOREIGN KEY(id_departamento) REFERENCES Departamento (id_departamento)
);

CREATE TABLE Etapa (
	id_etapa int PRIMARY KEY auto_increment not null,
	descricao varchar(45) not null unique,
	created_at timestamp not null,
	updated_at timestamp null
);

CREATE TABLE Arquivo (
	id_arquivo int PRIMARY KEY auto_increment not null,
	descricao varchar(45) not null,
	id_usuario int not null,
	id_etapa_trabalho int not null,
	created_at timestamp not null,
	updated_at timestamp null,
	FOREIGN KEY(id_usuario) REFERENCES Usuario (id_usuario),
	FOREIGN KEY(id_etapa_trabalho) REFERENCES EtapaTrabalho (id_etapa_trabalho)
);

CREATE TABLE Instituicao (
	id_instituicao int PRIMARY KEY auto_increment not null,
	nome varchar(50) not null unique,
	sigla varchar(10) not null unique,
	created_at timestamp not null,
	updated_at timestamp null
);

CREATE TABLE Telefone (
	id_telefone int PRIMARY KEY auto_increment not null,
	telefone varchar(15) not null,
	id_usuario int not null,
	created_at timestamp not null,
	updated_at timestamp null,
	FOREIGN KEY(id_usuario) REFERENCES Usuario (id_usuario)
);

CREATE TABLE CoordenadorCurso (
	id_coordenador_curso int PRIMARY KEY auto_increment not null,
	inicio_vigencia datetime not null,
	fim_vigencia datetime null,
	id_coordenador int not null,
	id_curso int not null,
	created_at timestamp not null,
	updated_at timestamp null,
	FOREIGN KEY(id_coordenador) REFERENCES MembroBanca (id_membrobanca),
	FOREIGN KEY(id_curso) REFERENCES Curso (id_curso)
);

ALTER TABLE AcademicoTrabalho ADD FOREIGN KEY(id_trabalho) REFERENCES Trabalho (id_trabalho);
ALTER TABLE AcademicoTrabalho ADD FOREIGN KEY(id_academico) REFERENCES Academico (id_academico);
ALTER TABLE BancaAvaliacao ADD FOREIGN KEY(id_etapa_trabalho) REFERENCES EtapaTrabalho (id_etapa_trabalho);
ALTER TABLE BancaAvaliacao ADD FOREIGN KEY(id_membrobanca) REFERENCES MembroBanca (id_membrobanca);
ALTER TABLE Academico ADD FOREIGN KEY(id_curso) REFERENCES Curso (id_curso);
ALTER TABLE EtapaAno ADD FOREIGN KEY(id_etapa) REFERENCES Etapa (id_etapa);
ALTER TABLE Departamento ADD FOREIGN KEY(id_instituicao) REFERENCES Instituicao (id_instituicao);
ALTER TABLE EtapaTrabalho ADD FOREIGN KEY(id_trabalho) REFERENCES Trabalho (id_trabalho);
ALTER TABLE Trabalho ADD FOREIGN KEY(id_orientador) REFERENCES MembroBanca (id_membrobanca);
ALTER TABLE Trabalho ADD FOREIGN KEY(id_coorientador) REFERENCES MembroBanca (id_membrobanca);
