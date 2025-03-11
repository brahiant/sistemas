<?php

// Incluimos el archivo de conexión para interactuar con la base de datos
require_once "../libraries/conexion.php";

// Definimos la clase EmpleadoModel para manejar las operaciones relacionadas con empleados
class EmpleadoModel
{
    // Atributo privado para almacenar la conexión a la base de datos
    private $conexion;

    // Constructor de la clase, se encarga de establecer la conexión a la base de datos
    function __construct()
    {
        // Creamos un nuevo objeto de la clase Conexion para establecer la conexión
        $this->conexion = new Conexion();
        // Llamamos al método estático conect para establecer la conexión
        $this->conexion = $this->conexion->conect();
    }

    // Método público para obtener un empleado específico por su ID
    public function getEmpleado(int $id_empleados)
    {
        // Ejecutamos una consulta para obtener el empleado, utilizando un procedimiento almacenado
        $rs = $this->conexion->query("CALL select_empleado('{$id_empleados}')");
        // Convertimos el resultado en un objeto y lo devolvemos
        $rs = $rs->fetch_object();
        return $rs;
    }

    // Método público para obtener todos los empleados
    public function getEmpleados()
    {
        // Inicializamos un arreglo para almacenar los registros obtenidos
        $arrRegistros = array();
        // Ejecutamos una consulta para obtener todos los empleados, utilizando un procedimiento almacenado
        $rs = $this->conexion->query("CALL select_empleados()");
        // Mientras haya registros, los vamos agregando al arreglo
        while ($obj = $rs->fetch_object()) {
            array_push($arrRegistros, $obj);
        }
        // Devolvemos el arreglo de registros
        return $arrRegistros;
    }

    // Método público para insertar un nuevo empleado
    public function insertEmpleado(string $nombre_completo, int $tipo_doc_id, int $numero_documento, int $estado_civil_id, string $email, string $telefono, string $direccion, int $ciudad_id)
    {
        // Ejecutamos una consulta para insertar el empleado, utilizando un procedimiento almacenado
        $rs = $this->conexion->query("CALL insert_empleado('{$nombre_completo}',{$tipo_doc_id},{$numero_documento},{$estado_civil_id},'{$email}','{$telefono}','{$direccion}',{$ciudad_id})");
        // Convertimos el resultado en un objeto y lo devolvemos
        $rs = $rs->fetch_object();
        return $rs;
    }

    // Método público para actualizar un empleado existente
    public function updateEmpleado(int $id_empleados, string $nombre_completo, int $tipo_doc_id, int $numero_documento, int $estado_civil_id, string $email, string $telefono, string $direccion, int $ciudad_id)
    {
        // Ejecutamos una consulta para actualizar el empleado, utilizando un procedimiento almacenado
        $rs = $this->conexion->query("CALL update_empleado('{$id_empleados}','{$nombre_completo}',{$tipo_doc_id},{$numero_documento},{$estado_civil_id},'{$email}','{$telefono}','{$direccion}',{$ciudad_id})");
        // Convertimos el resultado en un objeto y lo devolvemos
        $rs = $rs->fetch_object();
        return $rs;
    }

    // Método público para eliminar un empleado
    public function deleteEmpleado(int $id_empleados)
    {
        // Ejecutamos una consulta para eliminar el empleado, utilizando un procedimiento almacenado
        $rs = $this->conexion->query("CALL delete_empleado('{$id_empleados}')");
        // Convertimos el resultado en un objeto y lo devolvemos
        $rs = $rs->fetch_object();
        return $rs;
    }

}