CREATE DATABASE db_sistema;
USE db_sistema;

CREATE TABLE persona(
 `id_persona` bigint(20) NOT NULL auto_increment primary key,
 `nombre` VARCHAR(100) NOT NULL,
 `apellido` VARCHAR(100) NOT NULL,
 `telefono` bigint(20) NOT NULL,
 `email` VARCHAR(100) NOT NULL,
 `datecreated` DATETIME NOT NULL default current_timestamp,
 `status` VARCHAR(20) NOT NULL
)engine=InnoDB;

ALTER TABLE persona MODIFY COLUMN STATUS INT (1);

CREATE TABLE tarea(
 `id_tarea` bigint(20) NOT NULL auto_increment primary key,
 `nombre_tarea` VARCHAR(100) NOT NULL,
 `descripcion` VARCHAR(100) NOT NULL,
 `fecha_inicio` DATETIME NOT NULL default current_timestamp,
 `fecha_fin` DATETIME DEFAULT NULL,
 `persona_id` bigint(20),
 `status` VARCHAR(20) NOT NULL
)engine=InnoDB;

ALTER TABLE tarea ADD CONSTRAINT `TAREA_PERSONA_FK` FOREIGN KEY(`persona_id`) REFERENCES persona(`id_persona`) ON DELETE CASCADE ON UPDATE cascade;
/*ALTER TABLE tarea DROP FOREIGN KEY tarea_persona_fk*/


INSERT persona (nombre,apellido,telefono,email,datecreated,STATUS) values ('Fernando','Perez','135462356','fer@abelosh.com','2021-07-01',2)
																		  ,('Fabby','Torres','3413246587','ftorres@abelosh.com','2021-08-26',2); 
INSERT tarea (nombre_tarea,descripcion,fecha_inicio,persona_id,STATUS) values ('Maquetar web','Maquetar con html','2021-08-25',1,'activo');

SELECT * FROM persona pr INNER JOIN tarea tr ON pr.id_persona=tr.id_tarea;

UPDATE persona SET nombre= 'Carlos' WHERE id_persona=2;
DELETE from persona where id_persona;

/*Procedimientos almacenados*/

/*Retorna la lista de personas*/
delimiter $
create procedure select_peoples()
begin
   select*from persona;
end; $
delimiter ;

/*Retorna una persona*/
delimiter $
create procedure select_people(id bigint)
     begin
     select*from persona where id_persona=id;
     end; $
delimiter ;

/* Filtra mediante datos recibidos*/
delimiter $
create procedure search_peoples(search VARCHAR(100))
begin
 select id_persona, nombre, apellido, telefono, email from persona where
 (nombre LIKE CONCAT('%',search,'%') OR
 apellido LIKE CONCAT('%',search,'%') OR
 telefono LIKE CONCAT('%',search,'%') OR
 email LIKE CONCAT('%',search,'%')) AND STATUS !=0;
end; $
delimiter ;

/*Insertar datos*/
delimiter $
create procedure insert_people(nom VARCHAR(100), ape VARCHAR(100),tel BIGINT, emailp VARCHAR(100))
begin
  declare existe_persona int;
  declare id int;
  set existe_persona = (select COUNT(*) from persona where email=emailp);
  if existe_persona = 0 then
    insert into persona(nombre,apellido,telefono,email) VALUES (nom,ape,tel,emailp);
    set id= LAST_INSERT_ID();
  else
   SET id = 0;
  end if;
  select id;
end; $
delimiter ;

/*Modificar datos*/
delimiter $
create procedure update_people(id bigint,nom VARCHAR(100), ape VARCHAR(100),tel BIGINT, emailp VARCHAR(100))
begin
  declare existe_persona int;
  declare existe_email int;
  declare idp int;
  set existe_persona = (select COUNT(*) from persona where id_persona=id);
  if existe_persona > 0 then
      set existe_email =(select COUNT(*) from persona where email=emailp and id_persona != id);
      if existe_email=0 then
       update persona set nombre=nom, apellido=ape,telefono=tel,email=emailp where id_persona = id;
       set idp=id;
      else
       set idp=0;
      end if;
  else
   SET idp = 0;
  end if;
  select idp;
end; $
delimiter ;

/*Eliminar datos*/
delimiter $
create procedure delete_people(personaid bigint)
begin
  declare existe_persona int;
  declare id int;
  set existe_persona = (select COUNT(*) from persona where id_persona=personaid);
  if existe_persona > 0 then
      Delete from persona where id_persona=personaid;
      set id=1;
  else
   SET id = 0;
  end if;
  select id;
end; $
delimiter ;


/*Eliminar un procedimiento*/
DROP PROCEDURE select_peoples; 
/*Llamar procedimiento almacenado*/
call select_peoples();
call S_peoples();
call search_peoples("t");
call insert_people ('Angle','Castillo',34324232,'angel@info.com');
call update_people ('Angle','Castillo',34324232,'angel@info.com');
call delete_people(3);


