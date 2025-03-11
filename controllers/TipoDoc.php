<?php

require_once "../models/TipoDocModel.php";

$option = $_GET['op'];
$objetoTipoDoc = new TipoDocModel();

if($option == "listar"){
    $arrResponse = array('status' => false, 'data' => "");
    $arrTipoDoc = $objetoTipoDoc->getTipoDoc();
    if(!empty($arrTipoDoc)){
        $arrResponse['status'] = true;
        $arrResponse['data'] = $arrTipoDoc;
    }
    echo json_encode($arrResponse);
    die();
}
