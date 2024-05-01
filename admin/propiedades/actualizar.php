<?php

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

require '../../includes/app.php';

Autenticado();

$id = $_GET["id"];
$id = filter_var($id, FILTER_VALIDATE_INT);

//valida que sea un id valido
if (!$id) {
    header('Location: /bienesraices/admin/index.php');
}

//obtiene los datos de la propiedad
$propiedad = Propiedad::find($id);
$vendedores = Vendedor::getAll();

//arreglo con mensajes de error 
$errores = Propiedad::getErrores();

$titulo = $propiedad->titulo;
$precio = $propiedad->precio;
$descripcion = $propiedad->descripcion;
$habitaciones = $propiedad->habitaciones;
$wc = $propiedad->wc;
$estacionamiento = $propiedad->estacionamiento;
$vendedorId = $propiedad->vendedorId;
$imagenPropiedad = $propiedad->imagen;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		$args = $_POST['propiedad'];
		
		$propiedad->sincronizar($args);
		
		//validacion
		$errores = $propiedad->validar();
		
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        //generar un nombre unico 
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        /**  realiza un resize a la imagen con intervention */
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    }
		
    if (empty($errores)) {
				
				if(!$image == null){
            $image->save(CARPETA_IMAGENES . $nombreImagen);
				}
        $propiedad->guardar();
    }
}

incluirTemplate('header');
?>

		<main class="contenedor seccion">
				<h1>Actualizar Propiedad</h1>

				<a href="../index.php" class="boton boton-verde">Volver al panel</a>

        <?php foreach ($errores as $e) : ?>
						<div class="alerta error">
                <?php echo $e; ?>
						</div>

        <?php endforeach; ?>

				<form method="POST" class="formulario" enctype="multipart/form-data">

            <?php require '../../includes/templates/formulario_propiedades.php' ?>

						<input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
				</form>
		</main>

<?php
incluirTemplate('footer');
?>