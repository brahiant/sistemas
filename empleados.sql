-- Crear la base de datos 
CREATE DATABASE empleados;
-- Usar base de datos 
USE empleados;

-- Realización de las tablas de la DB
-- Tabla paises 
CREATE TABLE paises(
 `id_pais` bigint(20) NOT NULL auto_increment primary key,
 `nombre` VARCHAR(100) NOT NULL
)engine=InnoDB;

-- Tabla de estados(departamentos, provincias, etc)
CREATE TABLE estados(
`id_estado` bigint(20) NOT NULL auto_increment primary key,
`nombre` VARCHAR(100) NOT NULL,
`pais_id` bigint(20) NOT NULL
)engine=InnoDB;

ALTER TABLE estados ADD CONSTRAINT `ESTADO_PAIS_FK` FOREIGN KEY(`pais_id`) REFERENCES paises(`id_pais`) ON DELETE CASCADE ON UPDATE cascade;

-- Tabla de ciudades 
CREATE TABLE ciudades(
`id_ciudad` bigint(20) NOT NULL auto_increment primary key,
`nombre` VARCHAR(100) NOT NULL,
`estado_id` bigint(20) NOT NULL
)engine=InnoDB;

ALTER TABLE ciudades ADD CONSTRAINT `CIUDAD_ESTADO_FK` FOREIGN KEY(`estado_id`) REFERENCES estados(`id_estado`) ON DELETE CASCADE ON UPDATE cascade;
-- tabla de tipo de documento 
CREATE TABLE tipo_ducumento(
`id_tipo_doc` bigint(20) NOT NULL auto_increment primary key,
`nombre` VARCHAR(100) NOT NULL
)engine=InnoDB;
-- Tabla de estado civil 
CREATE TABLE estado_civil(
`id_estado_civil` bigint(20) NOT NULL auto_increment primary key,
`nombre` VARCHAR(100) NOT NULL
)engine=InnoDB;

-- Tabla de empleados
CREATE TABLE empleados(
`id_empleados` bigint(20) NOT NULL auto_increment primary key
`nombre_completo` VARCHAR(255) NOT NULL,
`tipo_doc_id` bigint(20) NOT NULL,
`numero_documento` BIGINT UNIQUE NOT NULL,
`estado_civil_id` bigint(20) NOT NULL,
`email` VARCHAR(100) UNIQUE NOT NULL,
`telefono` VARCHAR(20) NOT NULL,
`direccion` TEXT NOT NULL, 
`ciudad_id` bigint(20) NOT NULL,
)engine=InnoDB;

ALTER TABLE empleados ADD CONSTRAINT `EMPLEADO_TIPO_DOC_FK` FOREIGN KEY(`tipo_doc_id`) REFERENCES tipo_ducumento(`id_tipo_doc`) ON DELETE RESTRICT;
ALTER TABLE empleados ADD CONSTRAINT `EMPLEADO_ESTADO_CIVIL_FK` FOREIGN KEY(`estado_civil_id`) REFERENCES estado_civil(`id_estado_civil`) ON DELETE RESTRICT;
ALTER TABLE empleados ADD CONSTRAINT `EMPLEADO_CIUDAD_FK` FOREIGN KEY(`ciudad_id`) REFERENCES ciudades(`id_ciudad`) ON DELETE CASCADE;

-- Insertar datos en las tablas
INSERT INTO tipo_ducumento (nombre) VALUES ('DNI'), ('Carnet de residencia'), ('Pasaporte'), ('Cédula de ciudadanía'), ('Documento de identidad');
INSERT INTO estado_civil (nombre) VALUES ('Soltero'), ('Casado'), ('Divorciado'), ('Viudo'), ('Union libre');
INSERT INTO paises (nombre) VALUES ('Perú'), ('Chile'), ('Brasil'), ('Argentina'), ('Uruguay'), ('Paraguay'), ('Bolivia'), ('Ecuador'), ('Colombia'), ('Venezuela'), ('Guyana'), ('Surinam'), ('Guayana Francesa'), ('Brasil'), ('Argentina');
INSERT INTO estados (nombre, pais_id) VALUES ('Lima', 1), ('Santiago', 2), ('Rio de Janeiro', 3), ('Buenos Aires', 4), ('Montevideo', 5), ('Asunción', 6), ('La Paz', 7), ('Quito', 8), ('Bogotá', 9), ('Caracas', 10), ('Georgetown', 11), ('Paramaribo', 12), ('Cayena', 13), ('Brasília', 14);
INSERT INTO ciudades (nombre, estado_id) VALUES ('Lima', 1), ('Santiago', 2), ('Rio de Janeiro', 3), ('Buenos Aires', 4), ('Montevideo', 5), ('Asunción', 6), ('La Paz', 7), ('Quito', 8), ('Bogotá', 9), ('Caracas', 10), ('Georgetown', 11), ('Paramaribo', 12), ('Cayena', 13), ('Brasília', 14);

-- Insertar datos en la tabla de empleados
INSERT INTO empleados (nombre_completo, tipo_doc_id, numero_documento, estado_civil_id, email, telefono, direccion, ciudad_id) VALUES ('Juan Perez', 1, 1234567890, 1, 'juanperez@gmail.com', '9876543210', 'Av. Siempre Viva 123', 1);


// ... existing code ...

/* =================== PROCEDIMIENTOS ALMACENADOS =================== */

/* --------- Procedimientos para PAISES --------- */
DELIMITER $
/* Este procedimiento selecciona todos los países de la base de datos. */
CREATE PROCEDURE select_paises()
BEGIN
    SELECT * FROM paises WHERE id_pais > 0;
END; $
DELIMITER ;

DELIMITER $
/* Este procedimiento inserta un nuevo país en la base de datos si no existe ya. */
CREATE PROCEDURE insert_pais(IN nombre_pais VARCHAR(100))
BEGIN
    DECLARE existe INT;
    DECLARE id INT;
    SET existe = (SELECT COUNT(*) FROM paises WHERE nombre = nombre_pais);
    IF existe = 0 THEN
        INSERT INTO paises(nombre) VALUES (nombre_pais);
        SET id = LAST_INSERT_ID();
    ELSE
        SET id = 0;
    END IF;
    SELECT id;
END; $
DELIMITER ;

DELIMITER $
/* Este procedimiento actualiza el nombre de un país existente en la base de datos. */
CREATE PROCEDURE update_pais(IN id BIGINT, IN nombre_pais VARCHAR(100))
BEGIN
    DECLARE existe INT;
    SET existe = (SELECT COUNT(*) FROM paises WHERE id_pais = id);
    IF existe > 0 THEN
        UPDATE paises SET nombre = nombre_pais WHERE id_pais = id;
        SELECT id;
    ELSE
        SELECT 0;
    END IF;
END; $
DELIMITER ;

DELIMITER $
/* Este procedimiento elimina un país de la base de datos si existe. */
CREATE PROCEDURE delete_pais(IN id BIGINT)
BEGIN
    DECLARE existe INT;
    SET existe = (SELECT COUNT(*) FROM paises WHERE id_pais = id);
    IF existe > 0 THEN
        DELETE FROM paises WHERE id_pais = id;
        SELECT 1;
    ELSE
        SELECT 0;
    END IF;
END; $
DELIMITER ;

/* --------- Procedimientos para EMPLEADOS --------- */
DELIMITER $
/* Este procedimiento selecciona todos los empleados de la base de datos, incluyendo información adicional de sus países, estados, ciudades, tipo de documento y estado civil. */
CREATE PROCEDURE select_empleados()
BEGIN
    SELECT e.*, p.nombre as pais, es.nombre as estado, c.nombre as ciudad, 
           td.nombre as tipo_documento, ec.nombre as estado_civil
    FROM empleados e
    INNER JOIN ciudades c ON e.ciudad_id = c.id_ciudad
    INNER JOIN estados es ON c.estado_id = es.id_estado
    INNER JOIN paises p ON es.pais_id = p.id_pais
    INNER JOIN tipo_ducumento td ON e.tipo_doc_id = td.id_tipo_doc
    INNER JOIN estado_civil ec ON e.estado_civil_id = ec.id_estado_civil;
END; $
DELIMITER ;

DELIMITER $
/* Este procedimiento selecciona un empleado específico de la base de datos, incluyendo información adicional de sus países, estados, ciudades, tipo de documento y estado civil. */
CREATE PROCEDURE select_empleado(IN id BIGINT)
BEGIN
    SELECT e.*, p.nombre as pais, es.nombre as estado, c.nombre as ciudad, 
           td.nombre as tipo_documento, ec.nombre as estado_civil
    FROM empleados e
    INNER JOIN ciudades c ON e.ciudad_id = c.id_ciudad
    INNER JOIN estados es ON c.estado_id = es.id_estado
    INNER JOIN paises p ON es.pais_id = p.id_pais
    INNER JOIN tipo_ducumento td ON e.tipo_doc_id = td.id_tipo_doc
    INNER JOIN estado_civil ec ON e.estado_civil_id = ec.id_estado_civil
    WHERE e.id_empleados = id;
END; $
DELIMITER ;

DELIMITER $
/* Este procedimiento inserta un nuevo empleado en la base de datos si no existe ya un empleado con el mismo email o número de documento. */
CREATE PROCEDURE insert_empleado(
    IN p_nombre_completo VARCHAR(255),
    IN p_tipo_doc_id BIGINT,
    IN p_numero_documento BIGINT,
    IN p_estado_civil_id BIGINT,
    IN p_email VARCHAR(100),
    IN p_telefono VARCHAR(20),
    IN p_direccion TEXT,
    IN p_ciudad_id BIGINT
)
BEGIN
    DECLARE existe_email INT;
    DECLARE existe_documento INT;
    DECLARE id INT;
    
    SET existe_email = (SELECT COUNT(*) FROM empleados WHERE email = p_email);
    SET existe_documento = (SELECT COUNT(*) FROM empleados WHERE numero_documento = p_numero_documento);
    
    IF existe_email = 0 AND existe_documento = 0 THEN
        INSERT INTO empleados(
            nombre_completo, tipo_doc_id, numero_documento, 
            estado_civil_id, email, telefono, direccion, ciudad_id
        ) VALUES (
            p_nombre_completo, p_tipo_doc_id, p_numero_documento,
            p_estado_civil_id, p_email, p_telefono, p_direccion, p_ciudad_id
        );
        SET id = LAST_INSERT_ID();
    ELSE
        SET id = 0;
    END IF;
    SELECT id;
END; $
DELIMITER ;

DELIMITER $
/* Este procedimiento actualiza la información de un empleado existente en la base de datos si no existe ya otro empleado con el mismo email o número de documento. */
CREATE PROCEDURE update_empleado(
    IN p_id BIGINT,
    IN p_nombre_completo VARCHAR(255),
    IN p_tipo_doc_id BIGINT,
    IN p_numero_documento BIGINT,
    IN p_estado_civil_id BIGINT,
    IN p_email VARCHAR(100),
    IN p_telefono VARCHAR(20),
    IN p_direccion TEXT,
    IN p_ciudad_id BIGINT
)
BEGIN
    DECLARE existe INT;
    DECLARE existe_email INT;
    DECLARE existe_documento INT;
    
    SET existe = (SELECT COUNT(*) FROM empleados WHERE id_empleados = p_id);
    SET existe_email = (SELECT COUNT(*) FROM empleados WHERE email = p_email AND id_empleados != p_id);
    SET existe_documento = (SELECT COUNT(*) FROM empleados WHERE numero_documento = p_numero_documento AND id_empleados != p_id);
    
    IF existe > 0 AND existe_email = 0 AND existe_documento = 0 THEN
        UPDATE empleados SET
            nombre_completo = p_nombre_completo,
            tipo_doc_id = p_tipo_doc_id,
            numero_documento = p_numero_documento,
            estado_civil_id = p_estado_civil_id,
            email = p_email,
            telefono = p_telefono,
            direccion = p_direccion,
            ciudad_id = p_ciudad_id
        WHERE id_empleados = p_id;
        SELECT p_id;
    ELSE
        SELECT 0;
    END IF;
END; $
DELIMITER ;

DELIMITER $
/* Este procedimiento elimina un empleado de la base de datos si existe. */
CREATE PROCEDURE delete_empleado(IN id BIGINT)
BEGIN
    DECLARE existe INT;
    SET existe = (SELECT COUNT(*) FROM empleados WHERE id_empleados = id);
    IF existe > 0 THEN
        DELETE FROM empleados WHERE id_empleados = id;
        SELECT 1;
    ELSE
        SELECT 0;
    END IF;
END; $
DELIMITER ;

    /* --------- Procedimientos para CIUDADES --------- */
DELIMITER $
/* Este procedimiento selecciona todas las ciudades de la base de datos. */
CREATE PROCEDURE select_ciudades()
BEGIN
    SELECT * FROM ciudades WHERE id_ciudad > 0;
END; $
DELIMITER ;

DELIMITER $
/* Este procedimiento selecciona todas las ciudades de la base de datos. */
CREATE PROCEDURE select_tipo_doc()
BEGIN
    SELECT * FROM tipo_ducumento WHERE id_tipo_doc > 0;
END; $
DELIMITER ;

DELIMITER $
/* Este procedimiento selecciona todas las ciudades de la base de datos. */
CREATE PROCEDURE select_estado_civil()
BEGIN
    SELECT * FROM estado_civil WHERE id_estado_civil > 0;
END; $
DELIMITER ;

DELIMITER $
/* Este procedimiento inserta una nueva ciudad en la base de datos si no existe ya una ciudad con el mismo nombre. */


/* Ejemplos de uso:
CALL select_paises();
CALL insert_pais('Colombia');
CALL update_pais(1, 'México');
CALL delete_pais(5);

CALL select_empleados();
CALL insert_empleado('María García', 1, 987654321, 1, 'maria@email.com', '123456789', 'Calle Principal 123', 1);
CALL update_empleado(1, 'María López', 1, 987654321, 2, 'maria@email.com', '123456789', 'Calle Nueva 456', 1);
CALL delete_empleado(1);
*/