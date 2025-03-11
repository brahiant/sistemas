<?php

// Incluimos el archivo de conexión para interactuar con la base de datos
require_once "../libraries/conexion.php";

// Definimos la clase CiudadModel para manejar las operaciones relacionadas con ciudades
class CiudadModel
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

    // Método público para obtener las ciudades de la base de datos
    public function getCiudades()
    {
        // Inicializamos un arreglo para almacenar los registros obtenidos
        $arrRegistros = array();
        // Ejecutamos una consulta para obtener las ciudades, utilizando un procedimiento almacenado
        $rs = $this->conexion->query("CALL select_ciudades()");
        // Mientras haya registros, los vamos agregando al arreglo
        while ($obj = $rs->fetch_object()) {
            array_push($arrRegistros, $obj);
        }
        // Devolvemos el arreglo de registros
        return $arrRegistros;
    }
}