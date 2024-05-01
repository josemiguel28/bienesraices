<?php
require '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

Autenticado();

$propiedad = new Propiedad();
$vendedores = new Vendedor();
$vendedores = Vendedor::getAll();

//arreglo con mensajes de error 
$errores = Propiedad::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /**  CREA UNA NUEVA INSTANCIA */
    $propiedad = new Propiedad($_POST['propiedad']);

    //generar un nombre unico 
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        /**  realiza un resize a la imagen con intervention */
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    }

    /**  ACCEDE AL METODO DE PROPIEDADES PARA VALIDAR ENTRADAS */
    $errores = $propiedad->validar();

    if (empty($errores)) {
				//carpeta para subir imagenes
		    if(!is_dir(CARPETA_IMAGENES)){
						mkdir(CARPETA_IMAGENES);
		    }
	
        $image->save(CARPETA_IMAGENES . $nombreImagen);

        /** ACCEDE AL METODO DE LA PROPIEDAD PARA GUARDAR LOS DATOS */
       $propiedad->guardar();

    }
}


incluirTemplate('header');
?>

<main class="contenedor seccion">
		<h1>Crear</h1>

		<a href="../index.php" class="boton boton-verde">Volver al panel</a>

    <?php foreach ($errores as $e) : ?>
				<div class="alerta error">
            <?php echo $e; ?>
				</div>

    <?php endforeach; ?>

		<form method="POST" class="formulario" action="/bienesraices/admin/propiedades/crear.php"
		      enctype="multipart/form-data">
				
				<?php require '../../includes/templates/formulario_propiedades.php'; ?>

				<input type="submit" value="Crear Propiedad" class="boton boton-verde">
		</form>
</main>

<?php
incluirTemplate('footer');
?>