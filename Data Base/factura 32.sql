/*
	Nombre:		Factura 32
	Version:	beta_0.1 
    Fecha:		09/02/2021

Version 0.01 Factura Comercial, solo historial y uso manual.

*/

drop database if exists `factura_32`;
create database `factura_32` charset utf8 collate utf8_spanish_ci;
use `factura_32`;

drop table if exists `detalle_factura`;
create table `detalle_factura`(
`id_detalle_factura` int auto_increment primary key,
`nombre_empresa` varchar(50),
`direccion_empresa` varchar(50),
`correo_empresa` varchar(50),
`telefono_empresa` varchar(20)
)engine innodb;

drop table if exists `concepto_factura`;
create table `concepto_factura`(
`id_concepto` int auto_increment primary key,
`nombre_concepto` varchar(120),
`precio_concepto` decimal(12,2),
`cantidad_concepto` int,
`numero_factura` int,
`nombre_cliente` varchar(50),
`telefono_cliente` varchar(20),
`correo_cliente` varchar(50),
`fecha` varchar(50),
`concepto_detalle` int,
constraint `fk_concepto_detalle` foreign key(`concepto_detalle`) references `detalle_factura`(`id_detalle_factura`)
)engine innodb;