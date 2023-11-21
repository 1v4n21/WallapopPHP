<?php



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
    <a href="index.php" class="fixed top-4 left-4 p-4 text-white flex items-center z-50 rounded-md hover:bg-blue-700 transition-all duration-300">
        <i class="fas fa-arrow-left text-2xl"></i>
    </a>

    <!-- Anuncio -->
    <div class="container mx-auto mt-8">
        <div class="max-w-2xl bg-white p-8 mx-auto rounded shadow">
            <h1 class="text-2xl font-bold mb-4">Título del Anuncio</h1>

            <!-- Carrusel de Fotos (utilizando la librería Glide.js) -->
            <div class="glide">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        <li class="glide__slide"><img src="fotosAnuncios/hola.jpg" alt="Foto 1"></li>
                        <li class="glide__slide"><img src="fotosAnuncios/foto.jpg" alt="Foto 2"></li>
                        <li class="glide__slide"><img src="fotosAnuncios/hola.jpg" alt="Foto 3"></li>
                        <li class="glide__slide"><img src="fotosAnuncios/hola.jpg" alt="Foto 4"></li>
                    </ul>
                </div>
                <div class="glide__bullets" data-glide-el="controls[nav]">
                    <button class="glide__bullet" data-glide-dir="=0"></button>
                    <button class="glide__bullet" data-glide-dir="=1"></button>
                    <button class="glide__bullet" data-glide-dir="=2"></button>
                    <button class="glide__bullet" data-glide-dir="=3"></button>
                </div>
            </div>

            <p class="text-xl font-bold mt-4">Precio: $100</p>
            <br>
            <p class="text-gray-600 mb-4">Descripción del anuncio Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <br>
            <p class="text-gray-600">Dueño del Anuncio: Usuario123</p>
            <p class="text-gray-600">Localidad: Ciudad Ejemplo</p>
            <br>
            <p class="text-gray-600">Fecha de Creación: 01/01/2023</p>

            <!-- Botones -->
            <div class="flex justify-between mt-8">
                <button class="bg-green-500 text-white px-6 py-3 rounded hover:bg-green-600">Comprar</button>
                <button class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600">Iniciar Chat</button>
            </div>
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
