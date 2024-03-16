<?php

require_once "../libraries/conexion.php";
class PersonaModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    public function getPersona(int $id_persona)
    {
        $rs = $this->conexion->query("CALL select_people('{$id_persona}')");
        $rs = $rs->fetch_object();
        return $rs;
    }

    public function getPersonas()
    {
        $arrRegistros = array();
        $rs = $this->conexion->query("CALL select_peoples()");
        while ($obj = $rs->fetch_object()) {
            array_push($arrRegistros, $obj);
        }
        return $arrRegistros;
    }

    public function insertPersona(string $nombre, string $apellido, int $telefono, string $email)
    {
        $rs = $this->conexion->query("CALL insert_people('{$nombre}','{$apellido}',{$telefono},'{$email}')");
        $rs = $rs->fetch_object();
        return $rs;
    }

    public function updatePersona(int $id_persona, string $nombre, string $apellido, int $telefono, string $email){
        $rs= $this->conexion->query("CALL update_people('{$id_persona}','{$nombre}','{$apellido}',{$telefono},'{$email}')");
        $rs= $rs->fetch_object();
        return $rs;
    }
}
