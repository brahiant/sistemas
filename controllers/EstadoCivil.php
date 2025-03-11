<?php

// Incluimos el modelo de EstadoCivil para acceder a sus métodos
require_once "../models/EstadoCivilModel.php";

// Obtenemos la opción pasada por GET
$option = $_GET['op'];

// Creamos un objeto de EstadoCivilModel para interactuar con el modelo
$objetoEstadoCivil = new EstadoCivilModel();

// Verificamos si la opción es "listar"
if($option == "listar"){
    // Inicializamos el arreglo de respuesta con status false y data vacía
    $arrResponse = array('status' => false, 'data' => "");
    // Obtenemos los estados civiles del modelo
    $arrEstadoCivil = $objetoEstadoCivil->getEstadoCivil();
    // Verificamos si el arreglo de estados civiles no está vacío
    if(!empty($arrEstadoCivil)){
        // Si hay estados civiles, cambiamos el status a true y asignamos los datos
        $arrResponse['status'] = true;
        $arrResponse['data'] = $arrEstadoCivil;
    }
    // Convertimos el arreglo de respuesta a JSON y lo imprimimos
    echo json_encode($arrResponse);
    // Finalizamos el script para evitar ejecución adicional
    die();
}
