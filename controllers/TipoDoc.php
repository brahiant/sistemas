<?php

// Incluimos el modelo de TipoDocModel para acceder a sus métodos
require_once "../models/TipoDocModel.php";

// Obtenemos la opción pasada por GET
$option = $_GET['op'];

// Creamos un objeto de TipoDocModel para interactuar con el modelo
$objetoTipoDoc = new TipoDocModel();

// Verificamos si la opción es "listar"
if($option == "listar"){
    // Inicializamos el arreglo de respuesta con status false y data vacía
    $arrResponse = array('status' => false, 'data' => "");
    // Obtenemos los tipos de documentos del modelo
    $arrTipoDoc = $objetoTipoDoc->getTipoDoc();
    // Verificamos si el arreglo de tipos de documentos no está vacío
    if(!empty($arrTipoDoc)){
        // Si hay tipos de documentos, cambiamos el status a true y asignamos los datos
        $arrResponse['status'] = true;
        $arrResponse['data'] = $arrTipoDoc;
    }
    // Convertimos el arreglo de respuesta a JSON y lo imprimimos
    echo json_encode($arrResponse);
    // Finalizamos el script para evitar ejecución adicional
    die();
}
