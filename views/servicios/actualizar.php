<h1 class="nombre-pagina">Actualizar Servicios</h1>
<p class="descripcion-pagina">Modifica los valores del formulario</p>
<?php
    include_once __DIR__ ."../../templates/barra.php";
    include_once __DIR__ ."../../templates/alertas.php";
?>
<form method="post">
    <?php
        include_once __DIR__ . "/formulario.php";
    ?>
    <input type="submit" value="Guardar Servicio" class="boton">
</form>