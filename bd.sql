create database if not exists organizy;

use organizy;

create table if not exists usuaris (

id_usuari int auto_increment not null,
nom varchar (255) not null,
correu varchar (255) not null, 
contrasenya varchar (255) not null,
primary key (id_usuari)

);

create table if not exists projectes(

id_projecte int auto_increment not null,
nom varchar(255) not null,
descripcio varchar(255),
primary key (id_projecte)

);

create table if not exists rols(

id_rol int auto_increment not null,
nom varchar(255) not null,
primary key (id_rol)

);
create table if not exists tipus(

id_tipus int auto_increment not null,
nom varchar(255) not null,
primary key (id_tipus)

);
create table if not exists estats(

id_estat int auto_increment not null,
nom varchar(255) not null,
primary key (id_estat)

);

create table if not exists tasques(

id_tasca int auto_increment not null,
nom varchar(255) not null,
descripcio varchar(255),
id_usuari int,
id_projecte int not null,
id_estat int not null,
id_tipus int,
data_inici date,
data_fi date,
primary key (id_tasca),
constraint fk_usuari_tasca foreign key (id_usuari) references usuaris(id_usuari),
constraint fk_projecte_tasca foreign key (id_projecte) references projectes(id_projecte),
constraint fk_estat_tasca foreign key (id_estat) references estats(id_estat),
constraint fk_tipus_tasca foreign key (id_tipus) references tipus(id_tipus)

);

create table if not exists crear(

id_usuari int not null,
id_projecte int not null,
id_rol int not null,
primary key (id_usuari,id_projecte),
constraint fk_crear_usuari foreign key (id_usuari) references usuaris(id_usuari),
constraint fk_crear_rol foreign key (id_rol) references rols(id_rol),
constraint fk_crear_projecte foreign key (id_projecte) references projectes(id_projecte)

);