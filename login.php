<?php
//base de datos 
require 'includes/app.php';

$db = conectarDB(); 

$errores = [];
$usuario = '';
$password = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $usuario = mysqli_real_escape_string($db, filter_var($_POST['usuario'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$usuario){
        $errores[] = "El email es obligatorio";
    }

    if (!$password){
        $errores[] = "La contrasena es obligatoria";
    }

    if (empty($errores)){

        //validar que el usuario existe en la bd
        $query = "SELECT * FROM usuarios WHERE usuario =  '$usuario'";

        $resultado = mysqli_query($db, $query);

       
        if ($resultado ->num_rows){
            $usuario = mysqli_fetch_assoc($resultado);

            //verifica si el password es correcto 
            $auth = password_verify($password, $usuario['password']);

            
            if($auth){
                //el usuario esta autenticado 
                session_start();

                //llenar el arreglo de la sesion 
                $_SESSION['usuario'] = $usuario['usuario'];
                $_SESSION['login'] = true;

                header('Location: /bienesraices/admin/');

            }else{
                $errores[] = "La contrasena es incorrecta";
            }
        }else{
            $errores[] = "El usuario no existe";
        }
        
    }
}



incluirTemplate('header');

?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesion</h1>

    <?php foreach ($errores as $e) : ?>
       <div class="alerta error">
          <?php echo $e; ?>
       </div>

    <?php endforeach; ?>

    <form action="login.php" class="formulario" method="POST">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">Usuario</label>
            <input type="email" placeholder="Tu Email" id="email" name='usuario' >

            <label for="password">Password</label>
            <input type="password" placeholder="Tu Contraseña" id="password" name='password' >

        </fieldset>

        <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
    </form>
</main>

<?php

incluirTemplate('footer');

?>