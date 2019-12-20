-- base de donn�es: 'basehomecinema'
--
create database if not exists basehomecinema default character set utf8 collate utf8_general_ci;
use basehomecinema;
-- --------------------------------------------------------
-- creation des tables

set foreign_key_checks =0;

-- table client
drop table if exists client;
create table client (
	cli_id int not null auto_increment primary key,
	cli_nom varchar(50) not null,
	cli_adresse varchar(100) not null
)engine=innodb;

-- table installateur
drop table if exists installateur;
create table installateur (
	ins_id int not null auto_increment primary key,
	ins_nom varchar(50) not null
)engine=innodb; 

-- table appareil
drop table if exists appareil;
create table appareil (
	app_id int not null auto_increment primary key,
	app_marque varchar(50) not null
)engine=innodb; 


-- table contrat
drop table if exists contrat;
create table contrat (
	con_id int not null auto_increment primary key,
	con_date_debut date,
	con_date_fin date,
	con_client int not null,
	con_appareil int not null
)engine=innodb; 



-- table intervention
drop table if exists intervention;
create table intervention (
	int_id int not null auto_increment primary key,
	int_statut varchar(50) ,
	int_contrat int not null,
	int_installateur  int not null,
	int_type varchar(50),
	int_date date
)engine=innodb; 


-- contraintes
alter table contrat add constraint cs1 foreign key (con_client) references client(cli_id);
alter table contrat add constraint cs2 foreign key (con_appareil) references appareil(app_id);
alter table intervention add constraint cs3 foreign key (int_contrat) references contrat(con_id);
alter table intervention add constraint cs4 foreign key (int_installateur) references installateur(ins_id);

set foreign_key_checks = 1;

-- jeu de données

