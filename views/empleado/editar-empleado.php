<?php
require "../template/header.php";
?>
<main class="container">
    <h1 class="text-center">Crear Empleado</h1>
    <a href="<?= BASE_URL ?>/views/empleado/index.php" class="btn btn-success">Lista Empleados</a>
    <br/>
    <br/>
    <form id="frmEditar">
        <input type="hidden" id="txtId" name="txtId" required>
        <div class="mb-3">
            <label for="txtNombreCompleto" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" id="txtNombreCompleto" name="txtNombreCompleto"  placeholder="Nombres" required>
        </div>
        <div class="mb-3">
            <label for="listTipoDoc" class="form-label">Tipo de Documento</label>
            <select class="form-select" id="listTipoDoc" name="listTipoDoc" required>
                <option value="">Seleccione un tipo de documento</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="txtnumdoc" class="form-label">Numero de Documento</label>
            <input type="text" class="form-control" id="txtnumdoc" name="txtnumdoc"  placeholder="Numero de Documento" required>
        </div>
        <div class="mb-3">
            <label for="txtDireccion" class="form-label">Direccion</label>
            <input type="text" class="form-control" id="txtDireccion" name="txtDireccion"  placeholder="Apellidos" required>
        </div>
        <div class="mb-3">
            <label for="txtTelefono" class="form-label">Telefono</label>
            <input type="number" class="form-control" id="txtTelefono" name="txtTelefono"  placeholder="Numero de Telefono" required>
        </div>
        <div class="mb-3">
            <label for="txtEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="txtEmail" name="txtEmail"  placeholder="Correo Electrónico" required>
        </div>
        <div class="mb-3">
            <label for="listCiudad" class="form-label">Ciudad</label>
            <select class="form-select" id="listCiudad" name="listCiudad" required>
                <option value="">Seleccione una ciudad</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="listEstadoCivil" class="form-label">Estado Civil</label>
            <select class="form-select" id="listEstadoCivil" name="listEstadoCivil" required>
                <option value="">Seleccione un estado civil</option>
            </select>
        </div>
        <button type="submit" class="btn btn-info"><i class="fa-solid fa-user-pen"></i> Actualizar</button>
    </form>
</main>
<?php
require "../template/footer.php";
?>
<script src="../template/js/function-empleado.js"></script>
<script>
    let id=" <?= $_GET['p']?>";
    fntMostrar(id);
</script>