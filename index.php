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

    // Creamos la conexión utilizando la clase que hemos creado
    $connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    // Si existe la cookie y no ha iniciado sesión, le iniciamos sesión de forma automática
    if (!Sesion::getUsuario() && isset($_COOKIE['sid'])) {

        // Nos conectamos para obtener el id y la foto del usuario
        $usuariosDAO = new UsuariosDAO($conn);
        $usuario = $usuariosDAO->getBySid($_COOKIE['sid']);

        if ($usuario) {

            // Inicio sesión
            Sesion::iniciarSesion($usuario);

            // Creamos la cookie para que nos recuerde 7 días
            setcookie('sid', $usuario->getSid(), time() + 7 * 24 * 60 * 60, '/');

        } else {
            echo "No se pudo iniciar sesión automáticamente.";
        }
    }

    //Creamos el objeto anuncioDAO para acceder a BDD
    $anuncioDAO = new AnunciosDAO($conn);
    $anuncios = $anuncioDAO->getAnunciosNoVendidos();

    // Cerrar la conexión a la base de datos (puedes hacerlo después de utilizarla)
    $connexionDB->cerrarConexion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopSwap</title>

    <!--Link general CSS-->
    <link rel="stylesheet" href="estilo.css">

    <!--Link para TailWind-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <!-- Link jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!--Link para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--Iconos para la web-->
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">

    <!-- CSS -->
    <style>
        .error {
            display: none;
            padding: 15px;
            border-radius: 8px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .correcto {
            display: none;
            padding: 15px;
            border-radius: 8px;
            background-color: #28a745;
            border: 1px solid #218838;
            color: black;
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-b bg-blue-500 to-teal-700 text-white">
    <header>
        <?php if(Sesion::getUsuario()): ?>

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
                        <a class="navbar-item-inner flexbox-left">
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

                    <!-- Login -->
                    <li class="navbar-item flexbox-left">
                        <a class="navbar-item-inner flexbox-left">
                            <div class="navbar-item-inner-icon-wrapper flexbox">
                            <i class="fa-solid fa-user fa-beat-fade"></i>
                            </div>
                            <span class="link-text"><?= Sesion::getUsuario()->getEmail() ?></span>
                        </a>
                    </li>

                    <!-- Registro -->
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
        <?php else: ?>

            <!--Menu de navegacion con CSS si no esta logueado el usuario-->
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

                    <!-- Login -->
                    <li class="navbar-item flexbox-left">
                        <a href="login.php" class="navbar-item-inner flexbox-left">
                            <div class="navbar-item-inner-icon-wrapper flexbox">
                            <i class="fa-solid fa-user-lock fa-beat-fade"></i>
                            </div>
                            <span class="link-text">Login</span>
                        </a>
                    </li>

                    <!-- Registro -->
                    <li class="navbar-item flexbox-left">
                        <a href="registro.php" class="navbar-item-inner flexbox-left">
                            <div class="navbar-item-inner-icon-wrapper flexbox">
                            <i class="fa-solid fa-user-plus fa-beat-fade"></i>
                            </div>
                            <span class="link-text">Registro</span>
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
        <?php endif; ?>
    </header>
    <main id="main" class="flexbox-col">

        <!-- Mensaje de error -->     
        <?php imprimirMensaje(); ?>

        <!-- Mensaje de correcto -->     
        <?php imprimirMensajeC(); ?>

        <!--JavaScript-->
        <script>
            // Muestra el mensaje de error al cargar la página
            $(document).ready(function () {
                $(".error").fadeIn().delay(5000).fadeOut();
            });
        </script>

        <script>
            // Muestra el mensaje de correcto al cargar la página
            $(document).ready(function () {
                $(".correcto").fadeIn().delay(5000).fadeOut();
            });
        </script>

        <!--Titulo y descripcion del apartado Anuncios-->

        <section class="py-12">
            <div class="container mx-auto text-center">
                <h1 class="text-4xl font-extrabold mb-4">ShopSwap: Compra y Venta desde Casa</h1>
                <br>
                <p class="text-lg leading-relaxed mx-auto max-w-4xl font-semibold">
                    Descubre un universo de compra y venta en línea desde la comodidad de tu hogar con ShopSwap.
                    <br>
                    Explora nuestro amplio catálogo de productos, intercambia artículos con otros usuarios y transforma tu experiencia de compras con la conveniencia de la web.
                </p>
            </div>
        </section>

        <!-- Mostrar todos los anuncios existentes sin vender -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php foreach ($anuncios as $anuncio): ?>
                <div class="anuncio-container mb-8 transform transition-transform duration-300 hover:scale-105">
                    <div class="bg-white p-4 rounded shadow">
                        <h2 class="text-gray-600 text-xl font-semibold mb-2"><?= $anuncio->getTitulo(); ?></h2>
                        <p class="text-gray-600 mb-2"><?= $anuncio->getDescripcion(); ?></p>
                        <div class="flex space-x-2 mb-4">
                            <img src="<?= $anuncio->getFotoPrincipal(); ?>" alt="Foto principal" class="w-full h-48 object-cover mb-4 rounded-lg shadow">
                        </div>
                        <p class="text-gray-800 font-semibold"><?= $anuncio->getPrecio() . '€'; ?></p>
                        <p class="text-sm text-gray-500 mt-2">Fecha de creación: <?= $anuncio->getFechaCreacion() ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


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