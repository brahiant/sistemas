<?php
require "../template/header.php";
?>
<main class="container">
    <h1 class="text-center">lista de Empleados</h1>
    <a href="<?=BASE_URL?>views/empleado/crear-empleado.php" class="btn btn-success"><i class="fa-solid fa-user-plus"></i></a>
    <br>
    <table id="tblPersonas" class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Numero de Documento</th>
                <th scope="col">Direccion</th>
                <th scope="col">Telefono</th>
                <th scope="col">Email</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody id="tblBodyEmpleados">
        </tbody>
    </table>
</main>
<?php
require "../template/footer.php";
?>
<script src="../template/js/function-empleado.js"></script>