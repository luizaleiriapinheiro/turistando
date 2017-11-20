drop database turistando;
create database turistando 
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;
use turistando;

create table usuario(
id integer not null auto_increment,
nome varchar (50) not null,
email varchar (50) not null,
idade integer,
cidade varchar (50) not null,
nomeUsuario varchar (50) not null,
senha varchar (256) not null,
PRIMARY KEY (id));

create table fotoUsuario (
id int not null AUTO_INCREMENT,
nome varchar(255) not null,
tipo varchar(100) not null,
arquivo mediumblob,
idUsuario integer not null,
PRIMARY KEY (id));

create table viagem(
id integer not null auto_increment,
local varchar (50) not null,
descricao text not null,
idUsuario integer,
PRIMARY KEY (id));

create table foto (
id int not null AUTO_INCREMENT,
nome varchar(255) not null,
tipo varchar(100) not null,
arquivo mediumblob,
idViagem integer not null,
PRIMARY KEY (id));

create table categoria(
id integer not null auto_increment,
nome varchar (60) not null,
PRIMARY KEY (id));

create table usuario_tem_categoria(
idUsuario integer not null,
idCategoria integer not null,
PRIMARY KEY (idUsuario,idCategoria));

create table viagem_tem_categoria(
idViagem integer not null,
idCategoria integer not null,
PRIMARY KEY (idViagem,idCategoria));

alter table viagem add constraint usuarioId_fk
foreign key (idUsuario) references usuario (id);

alter table foto add constraint viagemId_fk
foreign key (idViagem) references viagem (id);

alter table fotoUsuario add constraint UsuarioFotoId_fk
foreign key (idUsuario) references usuario (id);

insert into categoria values (null, 'familia');
insert into categoria values (null, 'esportes radicais');
insert into categoria values (null, 'casal');
insert into categoria values (null, 'trabalho');
insert into categoria values (null, 'festas');
insert into categoria values (null, 'cultural');
insert into categoria values (null, 'sozinho (a)');
insert into categoria values (null, 'acadêmico');

select * from viagem;