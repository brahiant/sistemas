<?php

// Requerimos el modelo de Empleado para acceder a sus métodos
require_once "../models/EmpleadoModel.php";

// Obtenemos la opción pasada por GET
$option = $_GET['op'];
// Creamos un objeto de EmpleadoModel para interactuar con el modelo
$objetoEmpleado = new EmpleadoModel();


// Verificamos si la opción es "listregistrados"
if ($option == "listregistrados") {
   // Inicializamos el arreglo de respuesta con status false y data vacía
   $arrResponse = array('status' => false, 'data' => "");
   // Obtenemos los empleados del modelo
   $arrEmpleado = $objetoEmpleado->getEmpleados();
   // Verificamos si el arreglo de empleados no está vacío
   if (!empty($arrEmpleado)) {
      // Iteramos sobre el arreglo de empleados para agregar opciones de edición y eliminación
      for ($i = 0; $i < count($arrEmpleado); $i++) {
         // Obtenemos el ID del empleado
         $id_empleados = $arrEmpleado[$i]->id_empleados; // Corrected assignment
         // Creamos las opciones de edición y eliminación
         $options = '<a href="' . BASE_URL . 'views/empleado/editar-empleado.php?p=' . $id_empleados . '" class="btn btn-outline-primary btn-sm" title="Modificar Registro"><i class="fa-solid fa-user-pen"></i></a>
          <button onclick="fntDelEmpleado(' . $id_empleados . ')" class="btn btn-outline-danger btn-sm" title="Eliminar Registro"><i class="fa-solid fa-user-minus"></i></button>';
         // Asignamos las opciones al arreglo de empleados
         $arrEmpleado[$i]->options = $options;
      }
      // Cambiamos el status a true y asignamos los datos
      $arrResponse['status'] = true;
      $arrResponse['data'] = $arrEmpleado;
   }
   // Convertimos el arreglo de respuesta a JSON y lo imprimimos
   echo json_encode($arrResponse);
   // Finalizamos el script para evitar ejecución adicional
   die();
}
// Verificamos si la opción es "registro"
if ($option == "registro") {
   // Verificamos si se está enviando un formulario
   if ($_POST) {
      // Verificamos si todos los campos obligatorios están completos
      if (empty($_POST['txtNombreCompleto']) || empty($_POST['txtnumdoc']) || empty($_POST['txtDireccion']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listCiudad'])) {
         // Si algún campo está vacío, enviamos una respuesta de error
         $arrResponse = array('status' => false, 'msg' => 'Error: datos incompletos');
      } else {
         // Procesamos los datos del formulario
         $strNombre = ucwords(trim($_POST['txtNombreCompleto']));
         $strNumDoc = trim($_POST['txtnumdoc']);
         $strDireccion = ucwords(trim($_POST['txtDireccion']));
         $strTelefono = trim($_POST['txtTelefono']);
         $strEmail = strtolower(trim($_POST['txtEmail']));
         $id_ciudad = intval($_POST['listCiudad']);
         $id_estado_civil = intval($_POST['listEstadoCivil']);
         $id_tipo_doc = intval($_POST['listTipoDoc']);
         // Intentamos insertar el empleado
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
         // Verificamos si el empleado fue insertado correctamente
         if ($arrEmpleado->id > 0) {
            // Si el empleado fue insertado, enviamos una respuesta de éxito
            $arrResponse = array('status' => true, 'msg' => 'Registro guardado con éxito');
         } else {
            // Si el empleado no fue insertado, enviamos una respuesta de error
            $arrResponse = array('status' => false, 'msg' => 'Error: registro no guardado');
         }
      }
      // Convertimos el arreglo de respuesta a JSON y lo imprimimos
      echo json_encode($arrResponse);
   }
   // Finalizamos el script para evitar ejecución adicional
   die();
}
// Verificamos si la opción es "actualizar"
if ($option == "actualizar") {
   // Verificamos si se está enviando un formulario
   if($_POST){
      // Verificamos si todos los campos obligatorios están completos
      if (empty($_POST['txtNombreCompleto']) || empty($_POST['txtnumdoc']) || empty($_POST['txtDireccion']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listCiudad'])) {
         // Si algún campo está vacío, enviamos una respuesta de error
         $arrResponse = array('status' => false, 'msg' => 'Error: datos incompletos');
      } else {
         // Procesamos los datos del formulario
         $intId= intval($_POST['txtId']);
         $strNombre = ucwords(trim($_POST['txtNombreCompleto']));
         $strNumDoc = trim($_POST['txtnumdoc']);
         $strDireccion = ucwords(trim($_POST['txtDireccion']));
         $strTelefono = trim($_POST['txtTelefono']);
         $strEmail = strtolower(trim($_POST['txtEmail']));
         $id_ciudad = intval($_POST['listCiudad']);
         $id_estado_civil = intval($_POST['listEstadoCivil']);
         $id_tipo_doc = intval($_POST['listTipoDoc']);
         // Intentamos actualizar el empleado
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
         // Verificamos si el empleado fue actualizado correctamente
         if (is_object($arrEmpleado)) {
            // Si el empleado fue actualizado, enviamos una respuesta de éxito
            $arrResponse = array('status' => true, 'msg' => 'Registro guardado con éxito');
         } else {
            // Si el empleado no fue actualizado, enviamos una respuesta de error
            $arrResponse = array('status' => false, 'msg' => 'Error: registro no guardado');
         }
      }
      // Convertimos el arreglo de respuesta a JSON y lo imprimimos
      echo json_encode($arrResponse);
   }
}
// Verificamos si la opción es "verregistro"
if ($option == "verregistro") {
   // Verificamos si se está enviando un formulario
   if ($_POST) {
      // Obtenemos el ID del empleado a ver
      $id_empleados = intval($_POST['id_empleados']);
      // Intentamos obtener el empleado
      $arrEmpleado = $objetoEmpleado->getEmpleado($id_empleados);
      // Verificamos si el empleado fue encontrado
      if (empty($arrEmpleado)) {
         // Si el empleado no fue encontrado, enviamos una respuesta de error
         $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
      } else {
         // Si el empleado fue encontrado, preparamos la respuesta con los datos del empleado
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
      // Convertimos el arreglo de respuesta a JSON y lo imprimimos
      echo json_encode($arrResponse);
   }
   // Finalizamos el script para evitar ejecución adicional
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
