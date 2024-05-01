<?php

require '../includes/app.php';

use App\Propiedad;
use App\Vendedor;


Autenticado();

$propiedades = new Propiedad();
$vendedores = new Vendedor();

//implementar metodo para obtener las propiedades con active record
$propiedades = Propiedad::getAll();
$vendedores = Vendedor::getAll();

//muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

//eliminar una propiedad o vendedor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (validarTipoContenido($_POST['tipo'])) {

        switch ($_POST['tipo']) {
            case 'propiedad':
                $propiedades = Propiedad::find($id);
                //si la propiedad existe en la bd, elimina la propiedad de la bd
                if ($propiedades) {
                    $propiedades->eliminarUnRegistro($id);
                }
                break;

            case 'vendedor':
                $vendedor = Vendedor::find($id);

                //si la propiedad existe en la bd, elimina la propiedad de la bd
                if ($vendedor) {
                    $vendedor->eliminarUnRegistro($id);
                }
        }
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
		<h1>Pagina Admin</h1>

    <?php
    //dependiendo del codigo de la url muestra un mensaje
    $mensaje = mostrarMensaje(intval($resultado));
    if ($mensaje) { ?>
				<p class="alerta exito"><?php echo s($mensaje) ?></p>
    <?php } ?>
		
		<a href="propiedades/crear.php" class="boton boton-verde">Crear Propiedad<a></a>
				<a href="vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor<a></a>

						<h2>Propiedades</h2>

						<table class="propiedades">
								<thead>
								<tr>
										<th>ID</th>
										<th>Titulo</th>
										<th>Imagen</th>
										<th>Precio</th>
										<th>Acciones</th>
								</tr>
								</thead>

								<tbody> <!--muestra los resultados de la base de datos-->
                <?php foreach ($propiedades as $propiedad) : ?>
										<tr>
												<td> <?php echo $propiedad->id; ?></td>
												<td> <?php echo $propiedad->titulo; ?></td>
												<td><img src="/bienesraices/imagenes/<?php echo $propiedad->imagen; ?>" alt=" "
												         class="imagen-tabla"></td>
												<td> $ <?php echo $propiedad->precio; ?></td>
												<td>

														<form method="POST" action="" class="w-100">

																<input type="hidden" name="id" value="<?php echo $propiedad->id ?>">
																<input type="hidden" name="tipo" value="propiedad">
																<input type="submit" href="" class="boton-rojo-block" value="Eliminar">
														</form>

														<a href="/bienesraices/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>"
														   class="boton-amarillo-block">Actualizar</a>
												</td>
										</tr>
                <?php endforeach; ?>
								</tbody>
						</table>

						<h2>Vendedores</h2>

						<table class="propiedades">
								<thead>
								<tr>
										<th>ID</th>
										<th>Nombre</th>
										<th>Teléfono</th>
										<th>Acciones</th>
								</tr>
								</thead>

								<tbody> <!--muestra los resultados de la base de datos-->
                <?php foreach ($vendedores as $vendedor) : ?>
										<tr>
												<td> <?php echo $vendedor->id; ?></td>
												<td> <?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
												<td> <?php echo $vendedor->telefono; ?></td>

												<td>
														<form method="POST" action="" class="w-100">

																<input type="hidden" name="id" value="<?php echo $vendedor->id ?>">
																<input type="hidden" name="tipo" value="vendedor">
																<input type="submit" href="" class="boton-rojo-block" value="Eliminar">
														</form>

														<a href="/bienesraices/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>"
														   class="boton-amarillo-block">Actualizar</a>
												</td>
										</tr>
                <?php endforeach; ?>
								</tbody>
						</table>
</main>

<?php
incluirTemplate('footer');
?>


<script src="/bienesraices/build/js/bundle.min.js"></script>