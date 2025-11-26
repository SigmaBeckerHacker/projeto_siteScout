drop database db_escoteiro;
create database db_escoteiro;
use db_escoteiro;

create table tbUsuario (
    nome        varchar(100) not null,
    registro    numeric(8)   not null,
    funcao      varchar(50)  not null,
    email       varchar(100) not null,
    constraint pk_tbUsuario primary key (registro)
);

create table tbEscoteiro (
    nome      varchar(100) not null,
    registro  numeric(8)   not null,
    ramo      varchar(50)  not null,
    constraint pk_tbEscoteiro primary key (registro)
);


CREATE TABLE tbdistintivo (
  id_distintivo int AUTO_INCREMENT,
  nome_distintivo varchar(50) DEFAULT NULL,
	quantidade int DEFAULT NULL,
  categoria_distintivo varchar(50) DEFAULT NULL,
  imagem varchar(255) DEFAULT NULL,
  PRIMARY KEY (id_distintivo)
);

create table tbRequisicao (
    id_requisicao     int not null auto_increment,
    distintivo        varchar(255) not null,
    data_requisicao   date not null,
    registroChefe     numeric(8),
    constraint pk_tbRequisicao primary key (id_requisicao),
    constraint fk_tbRequisicao_registroChefe
        foreign key (registroChefe)
        references tbUsuario(registro)
        on delete cascade
        on update cascade
);

insert into tbUsuario values ("ADM", 12345678, "Administrador", "admin@exemplo.com") 