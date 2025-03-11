
function fntDelEmpleado(id) {

    Swal.fire({
        title: "Estas seguro de eliminar este registro?",
        showCancelButton: true,
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            let url = base_url + '/controllers/Empleado.php?op=eliminar';
            Swal.fire("Registro Eliminado !", "", "success");
        } else {
            Swal.fire("Acción cancelada", "", "info")
        }
    });

}


function fntDelEmpleado(id) {

    Swal.fire({
        title: "¿Estás seguro de eliminar este registro?",
        showCancelButton: true,
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            let url = base_url + '/controllers/Empleado.php?op=eliminar';
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({id_empleados: id}),
            })
            .then(response => response.json())
            .then(data => {
                if(data.status){    
                    Swal.fire("¡Registro Eliminado!", data.msg, "success");
                    // Recargar la tabla o actualizar la vista
                    location.reload();
                } else {
                    Swal.fire("Error", data.msg, "error");
                }
            })
            .catch(error => {
                console.error('Error detallado:', error);
                console.log('Error response:', error.response);
                console.log('Error message:', error.message);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: `Error al procesar la solicitud: ${error.message}`,
                });
            });
        } else {
            Swal.fire("Acción cancelada", "", "info")
        }
    });

}
