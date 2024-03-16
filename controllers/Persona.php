<?php

require_once "../models/PersonaModel.php";


$option = $_GET['op'];
$objetoPersona = new PersonaModel();

if ($option == "listregistrados") {
   $arrResponse = array('status' => false, 'data' => "");
   $arrPersona = $objetoPersona->getPersonas();
   if (!empty($arrPersona)) {
      for ($i = 0; $i < count($arrPersona); $i++) {
         $id_persona = $arrPersona[$i]->id_persona; // Corrected assignment
         $options = '<a href="' . BASE_URL . 'views/persona/editar-persona.php?p=' . $id_persona . '" class="btn btn-outline-primary btn-sm" title="Modificar Registro"><i class="fa-solid fa-user-pen"></i></a>
         <button onclick="fntDelPersona(' . $id_persona . ')" class="btn btn-outline-danger btn-sm" title="Eliminar Registro"><i class="fa-solid fa-user-minus"></i></button>';
         $arrPersona[$i]->options = $options;
      }
      $arrResponse['status'] = true;
      $arrResponse['data'] = $arrPersona;
   }
   echo json_encode($arrResponse);
   die();
}
if ($option == "registro") {
   if ($_POST) {
      if (empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail'])) {
         $arrResponse = array('status' => false, 'msg' => 'error datos');
      } else {
         $strNombre = ucwords(trim($_POST['txtNombre']));
         $strApellido = ucwords(trim($_POST['txtApellido']));
         $strTelefono = trim($_POST['txtTelefono']);
         $strEmail = strtolower(trim($_POST['txtEmail']));
         $arrPersona = $objetoPersona->insertPersona($strNombre, $strApellido, $strTelefono, $strEmail,true);
         if ($arrPersona->id > 0) {
            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
         } else {
            $arrResponse = array('status' => false, 'msg' => 'Datos no guardados correctamente');
         }
      }
      echo json_encode($arrResponse);
   } 
   die();
}
if ($option == "verregistro") {
   if($_POST){
      $id_persona = intval($_POST['id_persona']);
      $arrPersona = $objetoPersona->getPersona($id_persona);
      if(empty($arrPersona)){
         $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
      } else {
         $arrResponse = array('status' => true, 'msg' => 'datos encontrados', 'data'=>$arrPersona);
      }
      echo json_encode($arrResponse);
   }
   die();
}
if ($option == "actualizar") {
   if($_POST){
      if (empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtId'])) {
         $arrResponse = array('status' => false, 'msg' => 'error datos');
      } else {
         $intId= intval($_POST['txtId']);
         $strNombre = ucwords(trim($_POST['txtNombre']));
         $strApellido = ucwords(trim($_POST['txtApellido']));
         $strTelefono = trim($_POST['txtTelefono']);
         $strEmail = strtolower(trim($_POST['txtEmail']));
         $arrPersona = $objetoPersona->updatePersona($intId,$strNombre, $strApellido, $strTelefono, $strEmail);
         if ($arrPersona->idp > 0) {
            $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
         } else {
            $arrResponse = array('status' => false, 'msg' => 'Datos no actualizados correctamente');
         }
      }
      echo json_encode($arrResponse);
   }
}
if ($option == "eliminar") {
   echo "eliminar una persona";
}
die();
