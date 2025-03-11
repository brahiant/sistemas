<?php

// Incluimos el modelo de Ciudad para acceder a sus métodos
require_once "../models/CiudadModel.php";

// Obtenemos la opción pasada por GET
$option = $_GET['op'];

// Creamos un objeto de CiudadModel para interactuar con el modelo
$objetoCiudad = new CiudadModel();

// Verificamos si la opción es "listar"
if($option == "listar"){
    // Inicializamos el arreglo de respuesta con status false y data vacía
    $arrResponse = array('status' => false, 'data' => "");
    // Obtenemos las ciudades del modelo
    $arrCiudad = $objetoCiudad->getCiudades();
    // Verificamos si el arreglo de ciudades no está vacío
    if(!empty($arrCiudad)){
        // Si hay ciudades, cambiamos el status a true y asignamos los datos
        $arrResponse['status'] = true;
        $arrResponse['data'] = $arrCiudad;
    }
    // Convertimos el arreglo de respuesta a JSON y lo imprimimos
    echo json_encode($arrResponse);
    // Finalizamos el script para evitar ejecución adicional
    die();
}
