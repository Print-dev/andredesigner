CREATE DATABASE andredb;
USE andredb;

CREATE TABLE unidades_negocio (
	id	int auto_increment primary key,
    nombre varchar(80) null,
    codigo  varchar(80) null
) ENGINE = INNODB;

INSERT INTO a_usuarios (nombre, user, clave, obs) VALUES ('Royer', 'Royer', '$2y$10$YuM09FIFzdK8UxBp1mLC8.irxSYnXehxJQFMT.ftCiaNRCtFKIuCC','#F54927');
select * from a_usuarios
CREATE TABLE a_usuarios (
	id	int auto_increment primary key,
    sexo varchar(10)  null,
    nombre varchar(200)  null,
    tdoc varchar(30)  null,
    ndoc varchar(30)  null,
    repres varchar(200)  null,
    dnirep varchar(200)  null,
    pais varchar(200)  null,
    direccion varchar(200)  null,
    distrito varchar(200)  null,
    provincia varchar(200)  null,
    dpto varchar(200)  null,
    codtel varchar(50)  null,
    telefono varchar(200)  null,
    fecharegistro datetime  null,
    email varchar(200)  null,
    usuarioregistrador varchar(200)  null,
	sucursal int  null,
    nivel varchar(200)  null,
    user varchar(200)  null,
    clave varchar(200)  null,
	fechanac date  null,
    estado varchar(200) null,
    obs TEXT NULL
)ENGINE=INNODB;
select * from a_servicios
CREATE  TABLE a_servicios (
	id	int auto_increment primary key,
    fechar date null,
    titulo varchar(200) null,
    descripcion varchar(200) null,
    tipo varchar(200) null,
    img  text null,
    link text null,
    precio	varchar(20) null,
    hora_oferta_limite time null,
    fecha_oferta_limite date null,
    dscto 	varchar(20) null,
    estado varchar(15) null,
    orden varchar(15) null,
    moneda varchar(15) null,
    usuariomod varchar(20) null,
    obs		text null, -- TAGS OPCIONALES
	obs1 	text null, -- estado para ver en web
    obs2 	text null
)ENGINE=INNODB;

create TABLE a_producto_archivos (
	id int auto_increment primary key,
    productoid	int null,
    nombre		text null,
    url			text null,
    tamano 		varchar(20) null,
    fechar 		datetime null
)ENGINE=INNODB;

CREATE TABLE a_tablas (
	id int auto_increment primary key,
    fechar date null,
    tabla varchar(200) null,
    cod int null,
    hijo int null,
    obs text null,
    estado varchar(5)
)ENGINE=INNODB;

CREATE TABLE a_panel_movimientos (
	id int auto_increment primary key,
    unidad_negocio_id int null,
    tipo varchar(20) null, -- INGRESO, GASTO 
    concepto text null,
    cantidad int null,
    precio decimal(10,2) null, -- precio_vendido
    monto DECIMAL(10,2) NULL, -- precio_monto
    fecha date null, -- fecha de cuando se realizo ese movimiento, puede ser actual o pasado
    referencia TEXT null, -- nommbre y id del servicio 
    modo varchar(80) null,
	metodopago varchar(80) null, -- ejemplo: yape, tarjeta, etc
    ope	varchar(120) null, -- codigo de operacion de la compra, mas que todo para poder agrupar
    idagenda int null, -- en caso hayan asignado una filmacion para tal fecha
    usuario_registrador varchar(120) null,
    fechar date null -- fecha de registro automatico de este movimiento
) ENGINE = INNODB;

SELECT  * FROM a_servicios