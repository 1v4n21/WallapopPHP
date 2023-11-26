<?php

session_start();

require_once 'modelos/ConexionDB.php';
require_once 'modelos/Anuncio.php';
require_once 'modelos/AnunciosDAO.php';
require_once 'modelos/funciones.php';
require_once 'modelos/config.php';
require_once 'modelos/Sesion.php';
require_once 'modelos/Usuario.php';

//¡¡Página privada!! Esto impide que puedan ver esta página
//si no han iniciado sesión
if (!Sesion::getUsuario()) {
    header("location: index.php");
    guardarMensaje("No puedes eliminar anuncios si no has iniciado sesion");
    die();
}

// Creamos la conexión utilizando la clase que hemos creado
$connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
$conn = $connexionDB->getConnexion();

//Creamos el objeto AnunciosDAO para acceder a BBDD a través de este objeto
$anunciosDA0 = new AnunciosDAO($conn);

//Seguridad
if (!isset($_GET["id"])) {
    header("location: index.php");
    guardarMensaje("No puedes acceder a este apartado");
    die();
}

//Obtener el anuncio
$idAnuncio = htmlspecialchars($_GET["id"]);

$anuncio = $anunciosDA0->getAnuncioPorId($idAnuncio);

//Comprobamos que el anuncio pertenece al usuario conectado
if (Sesion::getUsuario()->getEmail() == $anuncio->getIdUsuario()) {
    //Elimina las fotos
    $anunciosDA0->eliminarFotosAnuncio($idAnuncio);

    //Elimina el anuncio
    $anunciosDA0->eliminarAnuncioPorId($idAnuncio);

    guardarMensajeC("Anuncio eliminado con éxito");
} else {
    guardarMensaje("No puedes borrar este anuncio");
}

header('location: misAnuncios.php');
die();
?>