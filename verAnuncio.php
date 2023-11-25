<?php

session_start();
require_once 'modelos/ConexionDB.php';
require_once 'modelos/Usuario.php';
require_once 'modelos/UsuariosDAO.php';
require_once 'modelos/Anuncio.php';
require_once 'modelos/AnunciosDAO.php';
require_once 'modelos/funciones.php';
require_once 'modelos/config.php';
require_once 'modelos/Sesion.php';

// Seguridad
if (!isset($_GET["id"]) || !isset($_GET["ruta"])) {
    header("location: index.php");
    guardarMensaje("No puedes acceder a este apartado");
    die();
}

// Creamos la conexión utilizando la clase que hemos creado
$connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
$conn = $connexionDB->getConnexion();

//Obtener la ruta de donde venimos
$ruta = $_GET['ruta'];

//Creamos el objeto anuncioDAO para acceder a BDD
$anuncioDAO = new AnunciosDAO($conn);
$anuncio = $anuncioDAO->getAnuncioPorId($_GET["id"]);

//Obtenemos las fotos del anuncio
$fotos = $anuncioDAO->obtenerNombresFotosPorIdAnuncio($_GET["id"]);

//Obtenemos el autor del anuncio
$usuarioDAO = new UsuariosDAO($conn);
$usuario = $usuarioDAO->getByEmail($anuncio->getIdUsuario());

//Obtener id
if(Sesion::getUsuario()){
    $usuarioLogueadoId = Sesion::getUsuario()->getEmail();
}else{
    $usuarioLogueadoId = "";
}

$creadorAnuncioId = $anuncio->getIdUsuario(); 

// Cerrar la conexión a la base de datos (puedes hacerlo después de utilizarla)
$connexionDB->cerrarConexion();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuncio - ShopSwap</title>

    <!--Link para TailWind-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <!-- Glide.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.4.1/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.4.1/dist/css/glide.theme.min.css">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!--Iconos para la web-->
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">

</head>
<body class="bg-gray-500">

    <!-- Icono en la esquina superior izquierda -->
    <a href="<?= $ruta ?>" class="fixed top-4 left-4 p-4 text-white flex items-center z-50 rounded-md hover:bg-blue-700 transition-all duration-300">
        <i class="fas fa-arrow-left text-2xl"></i>
    </a>

    <!-- Anuncio -->
    <div class="container mx-auto mt-8">
        <div class="max-w-2xl bg-white p-8 mx-auto rounded shadow">

            <!-- Titulo del anuncio -->
            <h1 class="text-2xl font-bold mb-4"><?= $anuncio->getTitulo() ?></h1>

            <!-- Carrusel de Fotos (utilizando la librería Glide.js) -->
            <div class="glide">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        <?php foreach ($fotos as $index => $foto): ?>
                            <li class="glide__slide">
                                <img src="<?= "fotosAnuncios/".$foto ?>" alt="Foto <?= (intval($index) + 1) ?>">
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="glide__bullets" data-glide-el="controls[nav]">
                    <?php foreach ($fotos as $index => $foto): ?>
                        <button class="glide__bullet" data-glide-dir="=<?= $index ?>"></button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Precio -->
            <p class="text-xl font-bold mt-4"><?= $anuncio->getPrecio() . "€"?></p>
            <br>

            <!-- Descripcion -->
            <p class="text-gray-600 mb-4"><?= htmlspecialchars_decode($anuncio->getDescripcion()) ?></p>
            <br>

            <!-- Dueño del anuncio -->
            <hr class="my-4">
            <p class="text-gray-600">
                <strong class="text-lg"><?= $usuario->getNombre() ?></strong>
                &nbsp;&nbsp;&nbsp;<span class="bg-yellow-300 px-2 py-1 rounded-md">Anunciante</span>
            </p>
            <hr class="my-4">

            <!-- Fecha de creacion -->
            <p class="text-gray-600">Fecha de Creación: <?= $anuncio->getFechaCreacion() ?></p>
            <br>

            <!-- Localidad del anuncio -->
            <p class="text-gray-600">Localidad: <?= $usuario->getPoblacion() ?></p>
            

            <!-- Botones y Mensaje (se muestran solo si el usuario logueado no es el creador del anuncio) -->
            <?php if ($usuarioLogueadoId !== $creadorAnuncioId): ?>
                <div class="flex justify-between mt-8">
                    <button class="bg-green-500 text-white px-6 py-3 rounded hover:bg-green-600">Comprar</button>
                    <button class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600">Iniciar Chat</button>
                </div>
            <?php elseif ($usuarioLogueadoId === $creadorAnuncioId): ?>
                <div class="mt-8 bg-green-200 p-4 rounded">
                    <p class="text-green-800 font-semibold">¡Este anuncio es tuyo!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <!-- Scripts para Glide.js -->
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.4.1/dist/glide.min.js"></script>
    <script>
        new Glide('.glide', {
            type: 'carousel',
            perView: 1, 
            focusAt: 'center',
            gap: 16
        }).mount();
    </script>

</body>
</html>
