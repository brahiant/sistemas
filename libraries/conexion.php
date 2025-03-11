<?php
// Incluimos el archivo de configuración para acceder a las constantes de la base de datos
require_once "../config/config.php";

// Definimos la clase Conexion para manejar la conexión a la base de datos
class Conexion{
    // Método estático para establecer la conexión a la base de datos
    public static function conect(){
        // Creamos un nuevo objeto mysqli para la conexión
        $mysql = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        // Establecemos el conjunto de caracteres para la conexión
        $mysql->set_charset(DB_CHARSET);
        // Verificamos si hubo un error al conectar
        if(mysqli_connect_errno()){
            // Si hubo un error, lo mostramos
            echo "Error: falla de conexion". mysqli_connect_error();
        }
        // Devolvemos el objeto de la conexión
        return $mysql;
    }
}

?>