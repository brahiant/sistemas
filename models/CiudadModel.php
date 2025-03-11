<?php

require_once "../libraries/conexion.php";
class CiudadModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    public function getCiudades()
    {
        $arrRegistros = array();
        $rs = $this->conexion->query("CALL select_ciudades()");
        while ($obj = $rs->fetch_object()) {
            array_push($arrRegistros, $obj);
        }
        return $arrRegistros;
    }
}