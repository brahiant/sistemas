<?php
 require_once "../config/config.php";

 class Conexion{
    public static function conect(){
        $mysql = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $mysql->set_charset(DB_CHARSET);
        if(mysqli_connect_errno()){
            echo "Error: falla de conexion". mysqli_connect_error();
        }
        return $mysql;
    }
}

//print_r(conexion::conect());
?>