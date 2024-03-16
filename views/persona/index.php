<?php
require "../template/header.php";
?>
<main class="container">
    <h1 class="text-center">lista de personas</h1>
    <a href="<?=BASE_URL?>views/persona/crear-persona.php" class="btn btn-success"><i class="fa-solid fa-user-plus"></i></a>
    <br>
    <table id="tblPersonas" class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Telefono</th>
                <th scope="col">Email</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody id="tblBodyPersonas">
        </tbody>
    </table>
</main>
<?php
require "../template/footer.php";
?>
<script src="../template/js/function-persona.js"></script>