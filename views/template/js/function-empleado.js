function validarFormulario(formulario) {
  // Obtener todos los campos del formulario
  const nombreCompleto = formulario.querySelector(
    '[name="txtNombreCompleto"]'
  ).value;
  const tipoDoc = formulario.querySelector('[name="listTipoDoc"]').value;
  const numDoc = formulario.querySelector('[name="txtnumdoc"]').value;
  const direccion = formulario.querySelector('[name="txtDireccion"]').value;
  const telefono = formulario.querySelector('[name="txtTelefono"]').value;
  const email = formulario.querySelector('[name="txtEmail"]').value;
  const ciudad = formulario.querySelector('[name="listCiudad"]').value;
  const estadoCivil = formulario.querySelector(
    '[name="listEstadoCivil"]'
  ).value;

  // Validar nombre completo (solo letras y espacios)
  if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,50}$/.test(nombreCompleto)) {
    Swal.fire({
      title: "Error",
      text: "El nombre solo debe contener letras y tener entre 3 y 50 caracteres",
      icon: "error",
    });
    return false;
  }

  // Validar número de documento (solo números, entre 8 y 12 dígitos)
  if (!/^\d{8,12}$/.test(numDoc)) {
    Swal.fire({
      title: "Error",
      text: "El número de documento debe contener entre 8 y 12 dígitos",
      icon: "error",
    });
    return false;
  }

  // Validar teléfono (solo números, 10 dígitos)
  if (!/^\d{10}$/.test(telefono)) {
    Swal.fire({
      title: "Error",
      text: "El teléfono debe contener 10 dígitos",
      icon: "error",
    });
    return false;
  }

  // Validar email
  if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(email)) {
    Swal.fire({
      title: "Error",
      text: "Por favor ingrese un email válido",
      icon: "error",
    });
    return false;
  }

  // Validar selects
  if (!tipoDoc || !ciudad || !estadoCivil) {
    Swal.fire({
      title: "Error",
      text: "Por favor seleccione todas las opciones requeridas",
      icon: "error",
    });
    return false;
  }

  return true;
}

// Función asíncrona para obtener los empleados registrados
async function getEmpleado() {
  try {
    // Realizamos una petición HTTP para obtener los empleados registrados
    let resp = await fetch(
      base_url + "controllers/Empleado.php?op=listregistrados"
    );
    // Convertimos la respuesta a JSON
    json = await resp.json();
    // Verificamos si la respuesta fue exitosa
    if (json.status) {
      // Obtenemos los datos de los empleados
      let data = json.data;
      // Iteramos sobre los datos para crear una fila en la tabla por cada empleado
      data.forEach((item) => {
        let newTr = document.createElement("tr");
        // Establecemos el id de la fila con el id del empleado
        newTr.id = "row_" + item.id_empleados;
        // Creamos el contenido de la fila
        newTr.innerHTML = `<tr>
                <th scope="row">${item.id_empleados}</th>
                <td>${item.nombre_completo}</td>
                <td>${item.numero_documento}</td>
                <td>${item.direccion}</td>
                <td>${item.telefono}</td>
                <td>${item.email}</td>
                <td>${item.options}</td>
             `;
        // Añadimos la fila al cuerpo de la tabla
        document.querySelector("#tblBodyEmpleados").appendChild(newTr);
      });
    }
  } catch (err) {
    // Manejamos el error si ocurre
    console.log("Ocurrio un error:" + err);
  }
}

// Función asíncrona para guardar un nuevo empleado
async function fntGuardar() {
  try {
    // Obtenemos el formulario de creación de empleados
    const frmCreate = document.getElementById("frmCreate");

    // Validar el formulario antes de enviar
    if (!validarFormulario(frmCreate)) {
      return;
    }

    // Creamos un objeto FormData para enviar los datos del formulario
    const data = new FormData(frmCreate);
    // Realizamos una petición HTTP para guardar el empleado
    let resp = await fetch(base_url + "controllers/Empleado.php?op=registro", {
      method: "POST",
      mode: "cors",
      cache: "no-cache",
      body: data,
    });
    // Convertimos la respuesta a JSON
    json = await resp.json();
    // Verificamos si la respuesta fue exitosa
    if (json.status) {
      // Mostramos un mensaje de éxito
      Swal.fire({
        title: "Exito",
        text: json.msg,
        icon: "success",
      });
      // Limpiamos el formulario
      document.getElementById("frmCreate").reset();
    } else {
      // Mostramos un mensaje de error
      Swal.fire({
        title: "Error",
        text: json.msg,
        icon: "error",
      });
    }
  } catch (err) {
    // Manejamos el error si ocurre
    console.log("Ocurrio un error " + err);
  }
}

// Función asíncrona para mostrar los detalles de un empleado
async function fntMostrar(id) {
  // Creamos un objeto FormData para enviar el id del empleado
  const formData = new FormData();
  formData.append("id_empleados", id);
  try {
    // Realizamos una petición HTTP para obtener los detalles del empleado
    let resp = await fetch(
      base_url + "controllers/Empleado.php?op=verregistro",
      {
        method: "POST",
        mode: "cors",
        cache: "no-cache",
        body: formData,
      }
    );
    // Convertimos la respuesta a JSON
    json = await resp.json();
    // Verificamos si la respuesta fue exitosa
    if (json.status) {
      // Establecemos los valores de los campos del formulario con los detalles del empleado
      document.querySelector("#txtId").value = json.data.id_empleados;
      document.querySelector("#txtNombreCompleto").value =
        json.data.nombre_completo;
      document.querySelector("#txtnumdoc").value = json.data.numero_documento;
      document.querySelector("#txtDireccion").value = json.data.direccion;
      document.querySelector("#txtTelefono").value = json.data.telefono;
      document.querySelector("#txtEmail").value = json.data.email;

      // Establecemos los valores de los selects
      document.querySelector("#listCiudad").value = json.data.ciudad_id;
      document.querySelector("#listTipoDoc").value = json.data.tipo_doc_id;
      document.querySelector("#listEstadoCivil").value =
        json.data.estado_civil_id;
    } else {
      // Redirigimos a la página de lista de empleados si no se encuentra el empleado
      window.location = base_url + "views/empleado/";
    }
  } catch (error) {
    // Manejamos el error si ocurre
    console.log("Ocurrio un error " + error);
  }
}

// Función asíncrona para editar un empleado
async function fntEditar() {
  try {
    // Obtenemos el formulario de edición de empleados
    const frmEditar = document.getElementById("frmEditar");

    // Validar el formulario antes de enviar
    if (!validarFormulario(frmEditar)) {
      return;
    }
    
    // Creamos un objeto FormData para enviar los datos del formulario
    const data = new FormData(frmEditar);
    // Realizamos una petición HTTP para editar el empleado
    let resp = await fetch(
      base_url + "controllers/Empleado.php?op=actualizar",
      {
        method: "POST",
        mode: "cors",
        cache: "no-cache",
        body: data,
      }
    );
    // Convertimos la respuesta a JSON
    json = await resp.json();
    // Verificamos si la respuesta fue exitosa
    if (json.status) {
      // Mostramos un mensaje de éxito
      Swal.fire({
        title: "Exito",
        text: json.msg,
        icon: "success",
      });
      // Limpiamos el formulario
      document.getElementById("frmEditar").reset();
    } else {
      // Mostramos un mensaje de error
      Swal.fire({
        title: "Error",
        text: json.msg,
        icon: "error",
      });
    }
  } catch (err) {
    // Manejamos el error si ocurre
    console.log("Ocurrio un error " + err);
  }
}

// Función para cargar las ciudades en el select
function cargarCiudades() {
  // URL para obtener las ciudades
  let url = base_url + "/controllers/Ciudad.php?op=listar";
  // Realizamos una petición HTTP para obtener las ciudades
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      // Verificamos si la respuesta fue exitosa
      if (data.status) {
        // Creamos el contenido del select
        let html = '<option value="">Seleccione una ciudad</option>';
        data.data.forEach((ciudad) => {
          html += `<option value="${ciudad.id_ciudad}">${ciudad.nombre}</option>`;
        });
        // Establecemos el contenido del select
        document.querySelector("#listCiudad").innerHTML = html;
      }
    })
    .catch((error) => {
      // Manejamos el error si ocurre
      console.error("Error:", error);
    });
}

// Función para cargar los tipos de documentos en el select
function cargarTipoDoc() {
  // URL para obtener los tipos de documentos
  let url = base_url + "/controllers/TipoDoc.php?op=listar";
  // Realizamos una petición HTTP para obtener los tipos de documentos
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      // Verificamos si la respuesta fue exitosa
      if (data.status) {
        // Creamos el contenido del select
        let html = '<option value="">Seleccione un tipo de documento</option>';
        data.data.forEach((tipoDoc) => {
          html += `<option value="${tipoDoc.id_tipo_doc}">${tipoDoc.nombre}</option>`;
        });
        // Establecemos el contenido del select
        document.querySelector("#listTipoDoc").innerHTML = html;
      }
    })
    .catch((error) => {
      // Manejamos el error si ocurre
      console.error("Error:", error);
    });
}

// Función para cargar los estados civiles en el select
function cargarEstadoCivil() {
  // URL para obtener los estados civiles
  let url = base_url + "/controllers/EstadoCivil.php?op=listar";
  // Realizamos una petición HTTP para obtener los estados civiles
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      // Verificamos si la respuesta fue exitosa
      if (data.status) {
        // Creamos el contenido del select
        let html = '<option value="">Seleccione un estado civil</option>';
        data.data.forEach((estadoCivil) => {
          html += `<option value="${estadoCivil.id_estado_civil}">${estadoCivil.nombre}</option>`;
        });
        // Establecemos el contenido del select
        document.querySelector("#listEstadoCivil").innerHTML = html;
      }
    })
    .catch((error) => {
      // Manejamos el error si ocurre
      console.error("Error:", error);
    });
}

// Verificamos si el elemento del cuerpo de la tabla de empleados existe
if (document.querySelector("#tblBodyEmpleados")) {
  // Llamamos a la función para obtener los empleados
  getEmpleado();
}

// Verificamos si el formulario de creación de empleados existe
if (document.querySelector("#frmCreate")) {
  // Obtenemos el formulario de creación de empleados
  let frmCreate = document.querySelector("#frmCreate");
  // Cargamos las ciudades, tipos de documentos y estados civiles
  cargarCiudades();
  cargarTipoDoc();
  cargarEstadoCivil();
  // Establecemos un listener para el evento de envío del formulario
  frmCreate.onsubmit = function (e) {
    // Evitamos el comportamiento predeterminado del formulario
    e.preventDefault();
    // Llamamos a la función para guardar el empleado
    fntGuardar();
  };
}

// Verificamos si el formulario de edición de empleados existe
if (document.querySelector("#frmEditar")) {
  // Obtenemos el formulario de edición de empleados
  let frmEditar = document.querySelector("#frmEditar");
  // Cargamos las ciudades, tipos de documentos y estados civiles
  cargarCiudades();
  cargarTipoDoc();
  cargarEstadoCivil();
  // Establecemos un listener para el evento de envío del formulario
  frmEditar.onsubmit = function (e) {
    // Evitamos el comportamiento predeterminado del formulario
    e.preventDefault();
    // Llamamos a la función para editar el empleado
    fntEditar();
  };
}
