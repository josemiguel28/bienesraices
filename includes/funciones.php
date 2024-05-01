<?php
define("TEMPLATES_URL", __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define("CARPETA_IMAGENES", __DIR__ . "../../imagenes/");

function incluirTemplate(string $template, bool $inicio = false)
{
    include TEMPLATES_URL . "/$template.php";
}

function Autenticado()
{
    session_start();

    if (!$_SESSION['login']) {
        header('Location: /bienesraices');
    }
}

function debuguear($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//sanitiza los inputs del html 
function s($html): string
{
    return htmlspecialchars($html);
}

function validarTipoContenido($tipo): bool
{
    $tipos = ['propiedad', 'vendedor'];

    return in_array($tipo, $tipos);
}

//muestra los mensajes
function mostrarMensaje($codigo)
{
    $mensaje = "";

    switch ($codigo) {
        case 1:
            $mensaje = "Creado Correctamente";
            break;
        case 2:
            $mensaje = "Actualizado Correctamente";
            break;
        case 3:
            $mensaje = "Eliminado Correctamente";
            break;
        default: 
            $mensaje = "";
    }
    
    return $mensaje;
}