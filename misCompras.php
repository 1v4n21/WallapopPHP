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

    //¡¡Página privada!! Esto impide que puedan ver esta página
    //si no han iniciado sesión
    if (!Sesion::getUsuario()) {
        header("location: index.php");
        guardarMensaje("No puedes ver tus anuncios si no has iniciado sesion");
        die();
    }

    // Creamos la conexión utilizando la clase que hemos creado
    $connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    //Paginacion de anuncios
    $paginaActual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

    //Creamos el objeto anuncioDAO para acceder a BDD
    $anuncioDAO = new AnunciosDAO($conn);
    $anuncios = $anuncioDAO->getComprasPorUsuario(Sesion::getUsuario()->getEmail(), ($paginaActual - 1) * 5);

    // Calcular el total de anuncios no vendidos
    $totalAnuncios = $anuncioDAO->getTotalComprasUsuario(Sesion::getUsuario()->getEmail());

    // Calcular el total de páginas
    $totalPaginas = ceil($totalAnuncios / 5);

    // Verificar si hay una página anterior
    $paginaAnterior = max(1, $paginaActual - 1);

    // Verificar si hay una página siguiente
    $paginaSiguiente = min($totalPaginas, $paginaActual + 1);

    // Cerrar la conexión a la base de datos (puedes hacerlo después de utilizarla)
    $connexionDB->cerrarConexion();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Compras - ShopSwap</title>

    <!--Link general CSS-->
    <link rel="stylesheet" href="estilo.css">

    <!--Link para TailWind-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <!--Link para los iconos FontAwesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--Iconos para la web-->
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">

</head>
<body class="bg-gradient-to-b bg-blue-500 to-teal-700 text-white">
    <header>

        <!--Menu de navegacion con CSS si esta logueado el usuario-->
        <nav id="navbar">
            <ul class="navbar-items flexbox-col">

                <!-- Logotipo -->
                <li class="navbar-logo flexbox-left">
                    <a class="navbar-item-inner flexbox">
                        <img src="images/favicon-32x32.png" alt="Imagen">
                    </a>
                </li>

                <!-- Anuncios -->
                <li class="navbar-item flexbox-left">
                    <a href="index.php" class="navbar-item-inner flexbox-left">
                        <div class="navbar-item-inner-icon-wrapper flexbox">
                            <i class="fa-solid fa-box-archive fa-beat-fade"></i>
                        </div>
                        <span class="link-text">Anuncios</span>
                    </a>
                </li>

                <!-- Mis Anuncios -->
                <li class="navbar-item flexbox-left">
                    <a href="misAnuncios.php" class="navbar-item-inner flexbox-left">
                        <div class="navbar-item-inner-icon-wrapper flexbox">
                            <i class="fa-solid fa-boxes-packing fa-beat-fade"></i>
                        </div>
                        <span class="link-text">Mis Anuncios</span>
                    </a>
                </li>

                <!-- Mis Compras -->
                <li class="navbar-item flexbox-left">
                    <a href="misCompras.php" class="navbar-item-inner flexbox-left">
                        <div class="navbar-item-inner-icon-wrapper flexbox">
                            <i class="fa-solid fa-basket-shopping fa-beat-fade"></i>
                        </div>
                        <span class="link-text">Mis compras</span>
                    </a>
                </li>

                <!-- Chat -->
                <li class="navbar-item flexbox-left">
                    <a class="navbar-item-inner flexbox-left">
                        <div class="navbar-item-inner-icon-wrapper flexbox">
                            <i class="fa-brands fa-rocketchat fa-beat-fade"></i>
                        </div>
                        <span class="link-text">Chat</span>
                    </a>
                </li>

                <!-- Usuario -->
                <li class="navbar-item flexbox-left">
                    <a class="navbar-item-inner flexbox-left">
                        <div class="navbar-item-inner-icon-wrapper flexbox">
                            <i class="fa-solid fa-user fa-beat-fade"></i>
                        </div>
                        <span class="link-text">
                            <?= Sesion::getUsuario()->getEmail() ?>
                        </span>
                    </a>
                </li>

                <!-- Cerrar Sesion -->
                <li class="navbar-item flexbox-left">
                    <a href="logout.php" class="navbar-item-inner flexbox-left">
                        <div class="navbar-item-inner-icon-wrapper flexbox">
                            <i class="fa-solid fa-right-from-bracket fa-beat-fade"></i>
                        </div>
                        <span class="link-text">Cerrar Sesion</span>
                    </a>
                </li>

                <!-- Filtro -->
                <li class="navbar-item flexbox-left">
                    <a class="navbar-item-inner flexbox-left">
                        <div class="navbar-item-inner-icon-wrapper flexbox">
                            <i class="fa-solid fa-magnifying-glass fa-beat-fade"></i>
                        </div>
                        <span class="link-text">Busqueda</span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <main id="main" class="flexbox-col">
        <!--Titulo apartado misCompras-->
        <section class="py-12">
            <div class="container mx-auto text-center">
                <h1 class="text-4xl font-extrabold mb-4 text-gray-800">Mis Compras</h1>
            </div>
        </section>

        <!-- Mostrar todas las compras existentes de un usuario -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php foreach ($anuncios as $anuncio): ?>
                <a href="verAnuncio.php?id=<?= $anuncio->getId() ?>&ruta=misCompras.php" class="anuncio-enlace">
                    <div class="anuncio-container mb-8 transform transition-transform duration-300 hover:scale-105">
                        <div class="bg-white p-4 rounded shadow">
                            <!-- Titulo -->
                            <h2 class="text-gray-600 text-xl font-semibold mb-2">
                                <?= $anuncio->getTitulo(); ?>
                            </h2>

                            <!-- Foto Principal -->
                            <div class="flex mb-4 aspect-w-1">
                                <img src="<?= "fotosAnuncios/" . $anuncio->getFotoPrincipal(); ?>" alt="Foto principal"
                                    class="h-48 w-60 object-cover rounded-lg shadow">
                            </div>

                            <!-- Precio -->
                            <p class="text-gray-800 font-semibold">
                                <?= $anuncio->getPrecio() . '€'; ?>
                            </p>

                            <!-- Fecha de creación -->
                            <p class="text-sm text-gray-500 mt-2">Fecha de creación:
                                <?= $anuncio->getFechaCreacion() ?>
                            </p>

                            <!-- Vendido o no vendido -->
                            <?php if ($anuncio->getVendido()): ?>
                                <p class="text-sm text-red-500 mt-2">¡Comprado!</p>
                            <?php else: ?>
                                <p class="text-sm text-green-500 mt-2">Disponible para la venta</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <br>

        <!-- Paginación para los anuncios -->
        <div class="flex items-center justify-between p-4 bg-blue-500 text-white border-t-4 border-b-4 border-blue-700">
            <?php if ($paginaActual > 1): ?>
                <a href="?pagina=<?php echo $paginaAnterior; ?>"
                    class="hover:underline hover:text-blue-300 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">Página
                    Anterior&nbsp;</a>
            <?php endif; ?>

            <span class="text-gray-200">
                <?php echo "Página $paginaActual de $totalPaginas"; ?>
            </span>

            <?php if ($paginaActual < $totalPaginas): ?>
                <a href="?pagina=<?php echo $paginaSiguiente; ?>"
                    class="hover:underline hover:text-blue-300 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">&nbsp;Página
                    Siguiente</a>
            <?php endif; ?>
        </div>

        <br>

    </main>

    <footer>
        <!--Footer de la web, con TailWind, parecido a Bootsrap-->

        <div class="footer">
            <div class="max-w-2xl mx-auto text-white py-10">
                <div class="text-center">
                    <h3 class="text-3xl mb-3"> Descarga tu app de compra-venta </h3>
                    <p> Con un solo click. </p>
                    <div class="flex justify-center my-10">
                        <div class="flex items-center border w-auto rounded-lg px-4 py-2 w-52 mx-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/888/888857.png" class="w-7 md:w-8">
                            <div class="text-left ml-3">
                                <p class='text-xs text-gray-200'>Descarga en </p>
                                <p class="text-sm md:text-base"> Google Play Store </p>
                            </div>
                        </div>
                        <div class="flex items-center border w-auto rounded-lg px-4 py-2 w-44 mx-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/888/888841.png" class="w-7 md:w-8">
                            <div class="text-left ml-3">
                                <p class='text-xs text-gray-200'>Descarga en </p>
                                <p class="text-sm md:text-base"> Apple Store </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-28 flex flex-col md:flex-row md:justify-between items-center text-sm text-gray-400">
                    <p class="order-2 md:order-1 mt-8 md:mt-0"> &copy; Shop Swap, 2023. </p>
                    <div class="order-1 md:order-2">
                        <span class="px-2">Sobre nosotros</span>
                        <span class="px-2 border-l">Contacto</span>
                        <span class="px-2 border-l">Politica de Privacidad</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>