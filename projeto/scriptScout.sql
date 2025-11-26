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

create table tbDistintivo (
    id_distintivo int not null,
    nome          varchar(100) not null,
    ramo          varchar(50) not null,
    constraint pk_tbDistintivo primary key (id_distintivo)
);

create table tbRequisicao (
    id_requisicao     int not null,
    distintivo        int not null,
    data_requisicao   date not null,
    status_requisicao varchar(30) not null,
    registroChefe     numeric(8),
    constraint pk_tbRequisicao primary key (id_requisicao),
    constraint fk_tbRequisicao_distintivo
        foreign key (distintivo)
        references tbDistintivo(id_distintivo)
        on delete cascade
        on update cascade,
    constraint fk_tbRequisicao_registroChefe
        foreign key (registroChefe)
        references tbUsuario(registro)
        on delete cascade
        on update cascade
);