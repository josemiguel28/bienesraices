<?php
include 'includes/app.php';
incluirTemplate('header');
?>

<main class="seccion contenedor">
    <h2 class="fw-300 centrar-texto">Casas y Depas en Venta</h2>

    <?php
        include 'includes/templates/anuncios.php';
    ?>
</main>

<?php
incluirTemplate('footer');
?>