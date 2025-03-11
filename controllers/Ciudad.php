<?php

require_once "../models/CiudadModel.php";

$option = $_GET['op'];
$objetoCiudad = new CiudadModel();

if($option == "listar"){
    $arrResponse = array('status' => false, 'data' => "");
    $arrCiudad = $objetoCiudad->getCiudades();
    if(!empty($arrCiudad)){
        $arrResponse['status'] = true;
        $arrResponse['data'] = $arrCiudad;
    }
    echo json_encode($arrResponse);
    die();
}
