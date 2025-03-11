<?php

require_once "../models/EmpleadoModel.php";

$option = $_GET['op'];
$objetoEmpleado = new EmpleadoModel();


if ($option == "listregistrados") {
   $arrResponse = array('status' => false, 'data' => "");
   $arrEmpleado = $objetoEmpleado->getEmpleados();
   if (!empty($arrEmpleado)) {
      for ($i = 0; $i < count($arrEmpleado); $i++) {
         $id_empleados = $arrEmpleado[$i]->id_empleados; // Corrected assignment
         $options = '<a href="' . BASE_URL . 'views/empleado/editar-empleado.php?p=' . $id_empleados . '" class="btn btn-outline-primary btn-sm" title="Modificar Registro"><i class="fa-solid fa-user-pen"></i></a>
          <button onclick="fntDelEmpleado(' . $id_empleados . ')" class="btn btn-outline-danger btn-sm" title="Eliminar Registro"><i class="fa-solid fa-user-minus"></i></button>';
         $arrEmpleado[$i]->options = $options;
      }
      $arrResponse['status'] = true;
      $arrResponse['data'] = $arrEmpleado;
   }
   echo json_encode($arrResponse);
   die();
}
if ($option == "registro") {
   if ($_POST) {
      if (empty($_POST['txtNombreCompleto']) || empty($_POST['txtnumdoc']) || empty($_POST['txtDireccion']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listCiudad'])) {
         $arrResponse = array('status' => false, 'msg' => 'Error: datos incompletos');
      } else {
         $strNombre = ucwords(trim($_POST['txtNombreCompleto']));
         $strNumDoc = trim($_POST['txtnumdoc']);
         $strDireccion = ucwords(trim($_POST['txtDireccion']));
         $strTelefono = trim($_POST['txtTelefono']);
         $strEmail = strtolower(trim($_POST['txtEmail']));
         $id_ciudad = intval($_POST['listCiudad']);
         $id_estado_civil = intval($_POST['listEstadoCivil']);
         $id_tipo_doc = intval($_POST['listTipoDoc']);
         $arrEmpleado = $objetoEmpleado->insertEmpleado(
            $strNombre,          // nombre_completo
            $id_tipo_doc,        // tipo_doc_id
            $strNumDoc,          // numero_documento
            $id_estado_civil,    // estado_civil_id
            $strEmail,           // email
            $strTelefono,        // telefono
            $strDireccion,       // direccion
            $id_ciudad,          // ciudad_id
            true
         );
         if ($arrEmpleado->id > 0) {
            var_dump($arrEmpleado);
            $arrResponse = array('status' => true, 'msg' => 'Registro guardado con éxito');
         } else {
            var_dump($arrEmpleado);
            $arrResponse = array('status' => false, 'msg' => 'Error: registro no guardado');
         }
      }
      echo json_encode($arrResponse);
   }
   die();
}
if ($option == "actualizar") {
   if($_POST){
      if (empty($_POST['txtNombreCompleto']) || empty($_POST['txtnumdoc']) || empty($_POST['txtDireccion']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listCiudad'])) {
         $arrResponse = array('status' => false, 'msg' => 'Error: datos incompletos');
      } else {
         $intId= intval($_POST['txtId']);
         $strNombre = ucwords(trim($_POST['txtNombreCompleto']));
         $strNumDoc = trim($_POST['txtnumdoc']);
         $strDireccion = ucwords(trim($_POST['txtDireccion']));
         $strTelefono = trim($_POST['txtTelefono']);
         $strEmail = strtolower(trim($_POST['txtEmail']));
         $id_ciudad = intval($_POST['listCiudad']);
         $id_estado_civil = intval($_POST['listEstadoCivil']);
         $id_tipo_doc = intval($_POST['listTipoDoc']);
         $arrEmpleado = $objetoEmpleado->updateEmpleado(
            $intId,
            $strNombre,          // nombre_completo
            $id_tipo_doc,        // tipo_doc_id
            $strNumDoc,          // numero_documento
            $id_estado_civil,    // estado_civil_id
            $strEmail,           // email
            $strTelefono,        // telefono
            $strDireccion,       // direccion
            $id_ciudad,          // ciudad_id
            true
         );
         if (is_object($arrEmpleado)) {
            $arrResponse = array('status' => true, 'msg' => 'Registro guardado con éxito');
         } else {
            $arrResponse = array('status' => false, 'msg' => 'Error: registro no guardado');
         }
      }
      echo json_encode($arrResponse);
   }
}
if ($option == "verregistro") {
   if ($_POST) {
      $id_empleados = intval($_POST['id_empleados']);
      $arrEmpleado = $objetoEmpleado->getEmpleado($id_empleados);
      if (empty($arrEmpleado)) {
         $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
      } else {
         // Modificamos la respuesta para incluir los IDs necesarios
         $arrResponse = array(
            'status' => true, 
            'msg' => 'datos encontrados', 
            'data' => array(
               'id_empleados' => $arrEmpleado->id_empleados,
               'nombre_completo' => $arrEmpleado->nombre_completo,
               'numero_documento' => $arrEmpleado->numero_documento,
               'direccion' => $arrEmpleado->direccion,
               'telefono' => $arrEmpleado->telefono,
               'email' => $arrEmpleado->email,
               'ciudad_id' => $arrEmpleado->ciudad_id,
               'tipo_doc_id' => $arrEmpleado->tipo_doc_id,
               'estado_civil_id' => $arrEmpleado->estado_civil_id
            )
         );
      }
      echo json_encode($arrResponse);
   }
   die();
}

// Verificar si la opción seleccionada es "eliminar"
if ($option == "eliminar") {
   // Establecer el tipo de contenido de la respuesta a JSON
   header('Content-Type: application/json');
   
   // Verificar si el método de la solicitud es POST
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       // Obtener los datos de la solicitud en formato JSON
       $data = json_decode(file_get_contents("php://input"), true);
       
       // Verificar si los datos JSON son inválidos
       if ($data === null) {
           // Enviar respuesta de error si los datos JSON son inválidos
           echo json_encode(['status' => false, 'msg' => 'Datos JSON inválidos']);
           // Terminar la ejecución del script
           die();
       }
       
       // Obtener el ID del empleado a eliminar
       $id_empleados = intval($data['id_empleados']);
       // Intentar eliminar el empleado
       $arrEmpleado = $objetoEmpleado->deleteEmpleado($id_empleados);
       
       // Preparar la respuesta basada en el resultado de la eliminación
       $arrResponse = [
           'status' => $arrEmpleado ? true : false,
           'msg' => $arrEmpleado ? 'Empleado eliminado correctamente' : 'Error al eliminar el empleado'
       ];
       
       // Enviar la respuesta
       echo json_encode($arrResponse);
   } else {
       // Enviar respuesta de error si el método de la solicitud no es POST
       echo json_encode(['status' => false, 'msg' => 'Método no permitido']);
   }
   // Terminar la ejecución del script
   die();
}
