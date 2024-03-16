async function getPersona() {
    try {
        let resp = await fetch(base_url + "controllers/Persona.php?op=listregistrados");
        json = await resp.json();
        if (json.status) {
            let data = json.data;
            data.forEach((item) => {
                let newTr = document.createElement("tr");
                newTr.id = "row_" + item.id_persona;
                newTr.innerHTML = `<tr>
                <th scope="row">${item.id_persona}</th>
                <td>${item.nombre}</td>
                <td>${item.apellido}</td>
                <td>${item.telefono}</td>
                <td>${item.email}</td>
                <td>${item.options}</td>
             `
                document.querySelector("#tblBodyPersonas").appendChild(newTr);
            });
        }
    } catch (err) {
        console.log("Ocurrio un error:" + err);
    }
}

async function fntGuardar() {
    try {
        let strNombre = document.querySelector("#txtNombre").value;
        let strApellido = document.querySelector("#txtApellido").value;
        let strTelefono = document.querySelector("#txtTelefono").value;
        let strEmail = document.querySelector("#txtEmail").value;
        const data = new FormData(frmCreate);
        let resp = await fetch(base_url + "controllers/Persona.php?op=registro", {
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
    formData.append('id_persona', id);
    try {
        let resp = await fetch(base_url + "controllers/Persona.php?op=verregistro", {
            method: 'POST',
            mode: 'cors',
            cahce: 'no-cache',
            body: formData
        });
        json = await resp.json();
        if (json.status) {
            document.querySelector("#txtId").value = json.data.id_persona;
            document.querySelector("#txtNombre").value = json.data.nombre;
            document.querySelector("#txtApellido").value = json.data.apellido;
            document.querySelector("#txtTelefono").value = json.data.telefono;
            document.querySelector("#txtEmail").value = json.data.email;
        } else {
            window.location = base_url + "views/persona/";
        }
    } catch (error) {
        console.log("Ocurrio un error " + error)
    }
}


async function fntEditar() {
    try {
        let intId = document.querySelector("#txtId").value;
        let strNombre = document.querySelector("#txtNombre").value;
        let strApellido = document.querySelector("#txtApellido").value;
        let strTelefono = document.querySelector("#txtTelefono").value;
        let strEmail = document.querySelector("#txtEmail").value;
        const data = new FormData(frmEditar);
        let resp = await fetch(base_url + "controllers/Persona.php?op=actualizar", {
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


if (document.querySelector("#tblBodyPersonas")) {
    getPersona();
}

if (document.querySelector("#frmCreate")) {
    let frmCreate = document.querySelector("#frmCreate");
    frmCreate.onsubmit = function (e) {
        e.preventDefault();
        fntGuardar();
    }
}

if(document.querySelector("#frmEditar")){
    let frmEditar = document.querySelector("#frmEditar");
    frmEditar.onsubmit = function(e){
        e.preventDefault();
        fntEditar();
    }
}