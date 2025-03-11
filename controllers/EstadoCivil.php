<?php

require_once "../models/EstadoCivilModel.php";

$option = $_GET['op'];
$objetoEstadoCivil = new EstadoCivilModel();

if($option == "listar"){
    $arrResponse = array('status' => false, 'data' => "");
    $arrEstadoCivil = $objetoEstadoCivil->getEstadoCivil();
    if(!empty($arrEstadoCivil)){
        $arrResponse['status'] = true;
        $arrResponse['data'] = $arrEstadoCivil;
    }
    echo json_encode($arrResponse);
    die();
}
