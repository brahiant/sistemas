async function getEmpleado() {
    try {
        let resp = await fetch(base_url + "controllers/Empleado.php?op=listregistrados");
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach((item) => {
                let newTr = document.createElement("tr");
                newTr.id = "row_" + item.id_empleados;
                newTr.innerHTML = `<tr>
                <th scope="row">${item.id_empleados}</th>
                <td>${item.nombre_completo}</td>
                <td>${item.numero_documento}</td>
                <td>${item.direccion}</td>
                <td>${item.telefono}</td>
                <td>${item.email}</td>
                <td>${item.options}</td>
             `
                document.querySelector("#tblBodyEmpleados").appendChild(newTr);
            });
        }
    } catch (err) {
        console.log("Ocurrio un error:" + err);
    }
}

async function fntGuardar() {
    try {
        const frmCreate = document.getElementById("frmCreate");
        const data = new FormData(frmCreate);
        let resp = await fetch(base_url + "controllers/Empleado.php?op=registro", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        json = await resp.json();
        if (json.status) {
            Swal.fire({
                title: "Exito",
                text: json.msg,
                icon: "success"
            });
            document.getElementById("frmCreate").reset();
        } else {
            Swal.fire({
                title: "Error",
                text: json.msg,
                icon: "error"
            });
        }
    } catch (err) {
        console.log("Ocurrio un error " + err)
    }

}

async function fntMostrar(id) {
    const formData = new FormData();
    formData.append('id_empleados', id);
    try {
        let resp = await fetch(base_url + "controllers/Empleado.php?op=verregistro", {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            document.querySelector("#txtId").value = json.data.id_empleados;
            document.querySelector("#txtNombreCompleto").value = json.data.nombre_completo;
            document.querySelector("#txtnumdoc").value = json.data.numero_documento;
            document.querySelector("#txtDireccion").value = json.data.direccion;
            document.querySelector("#txtTelefono").value = json.data.telefono;
            document.querySelector("#txtEmail").value = json.data.email;
            
            // Establecemos los valores de los selects
            document.querySelector("#listCiudad").value = json.data.ciudad_id;
            document.querySelector("#listTipoDoc").value = json.data.tipo_doc_id;
            document.querySelector("#listEstadoCivil").value = json.data.estado_civil_id;
        } else {
            window.location = base_url + "views/empleado/";
        }
    } catch (error) {
        console.log("Ocurrio un error " + error)
    }
}

async function fntEditar() {
    try {
        const frmEditar = document.getElementById("frmEditar");
        const data = new FormData(frmEditar);
        let resp = await fetch(base_url + "controllers/Empleado.php?op=actualizar", {
            method: 'POST',
            mode: 'cors',
            cahce: 'no-cache',
            body: data
        })
        json = await resp.json();
        if (json.status) {
            Swal.fire({
                title: "Exito",
                text: json.msg,
                icon: "success"
            });
            document.getElementById("frmEditar").reset();
        } else {
            Swal.fire({
                title: "Error",
                text: json.msg,
                icon: "error"
            });
        }
    } catch (err) {
        console.log("Ocurrio un error " + err)
    }

}

function cargarCiudades() {
    let url = base_url + '/controllers/Ciudad.php?op=listar';
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if(data.status){
                let html = '<option value="">Seleccione una ciudad</option>';
                data.data.forEach(ciudad => {
                    html += `<option value="${ciudad.id_ciudad}">${ciudad.nombre}</option>`;
                });
                document.querySelector('#listCiudad').innerHTML = html;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function cargarTipoDoc() {
    let url = base_url + '/controllers/TipoDoc.php?op=listar';
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if(data.status){
                let html = '<option value="">Seleccione un tipo de documento</option>';
                data.data.forEach(tipoDoc => {
                    html += `<option value="${tipoDoc.id_tipo_doc}">${tipoDoc.nombre}</option>`;
                });
                document.querySelector('#listTipoDoc').innerHTML = html;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function cargarEstadoCivil() {
    let url = base_url + '/controllers/EstadoCivil.php?op=listar';
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if(data.status){
                let html = '<option value="">Seleccione un estado civil</option>';
                data.data.forEach(estadoCivil => {
                    html += `<option value="${estadoCivil.id_estado_civil}">${estadoCivil.nombre}</option>`;
                });
                document.querySelector('#listEstadoCivil').innerHTML = html;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

if (document.querySelector("#tblBodyEmpleados")) {
    getEmpleado();
}

if (document.querySelector("#frmCreate")) {
    let frmCreate = document.querySelector("#frmCreate");
    cargarCiudades();
    cargarTipoDoc();
    cargarEstadoCivil();
    frmCreate.onsubmit = function (e) {
        e.preventDefault();
        fntGuardar();
    }
}

if(document.querySelector("#frmEditar")){
    let frmEditar = document.querySelector("#frmEditar");
    cargarCiudades();
    cargarTipoDoc();
    cargarEstadoCivil();
    frmEditar.onsubmit = function(e){
        e.preventDefault();
        fntEditar();
    }
}