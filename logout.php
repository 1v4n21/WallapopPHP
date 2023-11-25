<?php
    session_start();
    require_once 'modelos/Sesion.php';
    require_once 'modelos/funciones.php';

    //Seguridad
    if(!Sesion::getUsuario()){
        header("location: index.php");
        guardarMensaje("No puedes hacer logout si no has iniciado sesion");
        die();
    }

    //Borramos la variable de sesión y volvemos a index.php
    Sesion::cerrarSesion();

    setcookie('sid','',0,'/'); //Borra la cookie

    //Mensaje de logout con exito
    guardarMensajeC("Se ha cerrado sesion con éxito");

    header("location: index.php");

    die();
?>