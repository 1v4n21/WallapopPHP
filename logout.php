<?php
    session_start();
    require_once 'modelos/Sesion.php';

    //Borramos la variable de sesión y volvemos a index.php
    Sesion::cerrarSesion();

    setcookie('sid','',0); //Borra la cookie

    header('Location: index.php');
?>