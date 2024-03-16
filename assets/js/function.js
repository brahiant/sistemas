
function fntDelPersona(id) {

    Swal.fire({
        title: "Estas seguro de eliminar este registro?",
        showCancelButton: true,
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("Registro Eliminado !", "", "success");
        } else {
            Swal.fire("Acción cancelada", "", "info")
        }
    });

}

