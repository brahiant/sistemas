<?php

require_once "../libraries/conexion.php";
class EstadoCivilModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    public function getEstadoCivil()
    {
        $arrRegistros = array();
        $rs = $this->conexion->query("CALL select_estado_civil()");
        while ($obj = $rs->fetch_object()) {
            array_push($arrRegistros, $obj);
        }
        return $arrRegistros;
    }
}