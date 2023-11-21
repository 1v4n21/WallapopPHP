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
    if(!Sesion::getUsuario()){
        header("location: index.php");
        guardarMensaje("No puedes subir anuncios si no has iniciado sesion");
        die();
    }



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Anuncio - ShopSwap</title>

    <!--Link para TailWind-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <!--Links para utilizar JQTextEditor-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.js"></script>

    <!--Iconos para la web-->
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">
</head>
<body class="p-6 bg-gray-900">
    <!--Formulario de creacion de Anuncio con TailWind, parecido a Bootsrap-->

    <div class="max-w-md mx-auto bg-white rounded-md p-8 shadow-md">

        <!-- Icono en la esquina superior izquierda -->
        <a href="misAnuncios.php" class="fixed top-4 left-4 p-4 bg-blue-500 text-white flex items-center z-50 border border-white rounded-md hover:bg-blue-700">
            <img src="images/favicon-32x32.png" alt="Icono de la web" class="w-8 h-8">
            <span class="font-bold ml-2">ShopSwap</span>
        </a>

        
        <h1 class="text-2xl font-semibold mb-6">Añadir Anuncio</h1>
        <form action="crearAnuncio.php" method="post" enctype="multipart/form-data">

            <!-- Titulo -->
            <div class="mb-4">
                <label for="titulo" class="block text-sm font-medium text-gray-600">Título</label>
                <input type="text" name="titulo" id="titulo" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!--Textarea de JQTextEditor---->
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-600">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="jqte mt-1 p-2 w-full border rounded-md" rows="5"></textarea>
            </div>

            <!-- Foto Principal -->
            <div class="mb-4">
                <label for="fotoPrincipal" class="block text-sm font-medium text-gray-600">Foto Principal</label>
                <input type="file" name="fotoPrincipal" id="fotoPrincipal" accept="image/*" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Foto2 -->
            <div class="mb-4">
                <label for="foto2" class="block text-sm font-medium text-gray-600">Foto 2 (opcional)</label>
                <input type="file" name="foto2" id="foto2" accept="image/*" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Foto3 -->
            <div class="mb-4">
                <label for="foto3" class="block text-sm font-medium text-gray-600">Foto 3 (opcional)</label>
                <input type="file" name="foto3" id="foto3" accept="image/*" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Foto4 -->
            <div class="mb-4">
                <label for="foto4" class="block text-sm font-medium text-gray-600">Foto 4 (opcional)</label>
                <input type="file" name="foto4" id="foto4" accept="image/*" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Precio -->
            <div class="mb-4">
                <label for="precio" class="block text-sm font-medium text-gray-600">Precio</label>
                <div class="relative">
                    <input type="number" name="precio" id="precio" class="mt-1 p-2 w-full border rounded-md">
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                        €
                    </span>
                </div>
            </div>

            <!-- Boton de Enviar -->
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md transition duration-300 ease-in-out transform hover:scale-105">Publicar Anuncio</button>
            </div>

        </form>
    </div>


    <!-- Inicializar el editor de texto jQuery TextEditor -->
    <script>
        $(document).ready(function () {
            // Inicializar el plugin jQuery TE en el textarea con id "descripcion"
            $("#descripcion").jqte({
                'format': false,
                'fsize': true,
                'color': true,
                'sub': false,
                'sup': false,
                'unlink': false,
                'outdent': false,
                'indent': false,
                'image': false,
                'removeformat': false,
                'format': false,
                'source': false,
                'strike': false,
                'table': false,
                'left': false,
                'center': false,
                'right': false,
                'uppercase': false,
                'lowercase': false,
                'rule': false,
                'link': false,
                'lists': true,
            });
        });
    </script>
</body>
</html>
