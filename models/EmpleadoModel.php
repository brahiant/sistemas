<?php

require_once "../libraries/conexion.php";
class EmpleadoModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    public function getEmpleado(int $id_empleados)
    {
        $rs = $this->conexion->query("CALL select_empleado('{$id_empleados}')");
        $rs = $rs->fetch_object();
        return $rs;
    }

    public function getEmpleados()
    {
        $arrRegistros = array();
        $rs = $this->conexion->query("CALL select_empleados()");
        while ($obj = $rs->fetch_object()) {
            array_push($arrRegistros, $obj);
        }
        return $arrRegistros;
    }

    public function insertEmpleado(string $nombre_completo, int $tipo_doc_id, int $numero_documento, int $estado_civil_id, string $email, string $telefono, string $direccion, int $ciudad_id)
    {
        $rs = $this->conexion->query("CALL insert_empleado('{$nombre_completo}',{$tipo_doc_id},{$numero_documento},{$estado_civil_id},'{$email}','{$telefono}','{$direccion}',{$ciudad_id})");
        $rs = $rs->fetch_object();
        return $rs;
    }

    public function updateEmpleado(int $id_empleados, string $nombre_completo, int $tipo_doc_id, int $numero_documento, int $estado_civil_id, string $email, string $telefono, string $direccion, int $ciudad_id)
    {
        $rs = $this->conexion->query("CALL update_empleado('{$id_empleados}','{$nombre_completo}',{$tipo_doc_id},{$numero_documento},{$estado_civil_id},'{$email}','{$telefono}','{$direccion}',{$ciudad_id})");
        $rs = $rs->fetch_object();
        return $rs;
    }

    public function deleteEmpleado(int $id_empleados)
    {
        $rs = $this->conexion->query("CALL delete_empleado('{$id_empleados}')");
        $rs = $rs->fetch_object();
        return $rs;
    }

}