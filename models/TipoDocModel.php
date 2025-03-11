<?php

require_once "../libraries/conexion.php";
class TipoDocModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    public function getTipoDoc()
    {
        $arrRegistros = array();
        $rs = $this->conexion->query("CALL select_tipo_doc()");
        while ($obj = $rs->fetch_object()) {
            array_push($arrRegistros, $obj);
        }
        return $arrRegistros;
    }
}