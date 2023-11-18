<?php 
    session_start();
    require_once 'modelos/funciones.php';
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
    </style>
</head>
<body class="bg-gradient-to-b bg-blue-500 to-teal-700 text-white">
    <header>
        <!--Menu de navegacion con CSS-->

        <nav id="navbar">
        <ul class="navbar-items flexbox-col">
            <li class="navbar-logo flexbox-left">
            <a class="navbar-item-inner flexbox">
                <img src="images/favicon-32x32.png" alt="Imagen">
            </a>
            </li>
            <li class="navbar-item flexbox-left">
            <a href="index.php" class="navbar-item-inner flexbox-left">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                <i class="fa-solid fa-box-archive fa-beat-fade"></i>
                </div>
                <span class="link-text">Anuncios</span>
            </a>
            </li>
            <li class="navbar-item flexbox-left">
            <a href="misAnuncios.php" class="navbar-item-inner flexbox-left">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                <i class="fa-solid fa-boxes-packing fa-beat-fade"></i>
                </div>
                <span class="link-text">Mis Anuncios</span>
            </a>
            </li>
            <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                <i class="fa-solid fa-basket-shopping fa-beat-fade"></i>
                </div>
                <span class="link-text">Mis compras</span>
            </a>
            </li>
            <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                <i class="fa-brands fa-rocketchat fa-beat-fade"></i>
                </div>
                <span class="link-text">Chat</span>
            </a>
            </li>
            <li class="navbar-item flexbox-left">
            <a href="login.php" class="navbar-item-inner flexbox-left">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                <i class="fa-solid fa-circle-check fa-beat-fade"></i>
                </div>
                <span class="link-text">Login</span>
            </a>
            </li>
            <li class="navbar-item flexbox-left">
            <a href="registro.php" class="navbar-item-inner flexbox-left">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                <i class="fa-regular fa-registered fa-beat-fade"></i>
                </div>
                <span class="link-text">Registro</span>
            </a>
            </li>
            <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                <ion-icon name="settings-outline"></ion-icon>
                </div>
                <span class="link-text">Settings</span>
            </a>
            </li>
        </ul>
        </nav>
    </header>
    <main id="main" class="flexbox-col">

        <?php imprimirMensaje(); ?>

        <!--JavaScript-->
        <script>
            // Muestra el mensaje de error al cargar la página
            $(document).ready(function () {
                $(".error").fadeIn().delay(5000).fadeOut();
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