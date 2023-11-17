<?php 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopSwap</title>

    <link rel="stylesheet" href="estilo.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">
    <style>

    </style>
</head>
<body>
    <header>
        <nav id="navbar">
        <ul class="navbar-items flexbox-col">
            <li class="navbar-logo flexbox-left">
            <a class="navbar-item-inner flexbox">
                <img src="images/favicon-32x32.png" alt="Imagen">
            </a>
            </li>
            <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                <i class="fa-solid fa-box-archive fa-beat-fade"></i>
                </div>
                <span class="link-text">Anuncios</span>
            </a>
            </li>
            <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left">
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
            <a class="navbar-item-inner flexbox-left">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                <i class="fa-solid fa-circle-check fa-beat-fade"></i>
                </div>
                <span class="link-text">Login</span>
            </a>
            </li>
            <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left">
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
        <br><br>
        <h2>Lorem ipsum!</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum corporis, rerum doloremque iste sed voluptates omnis molestias molestiae animi recusandae labore sit amet delectus ad necessitatibus laudantium qui! Magni quisquam illum quaerat necessitatibus sint quibusdam perferendis! Aut ipsam cumque deleniti error perspiciatis iusto accusamus consequuntur assumenda. Obcaecati minima sed natus?</p>
    </main>
    <footer>
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