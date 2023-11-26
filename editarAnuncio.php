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

    // Página privada: redirige si no ha iniciado sesión
    if (!Sesion::getUsuario()) {
        header("location: index.php");
        guardarMensaje("No puedes editar anuncios si no has iniciado sesión");
        die();
    }

    // Seguridad
    if (!isset($_GET["id"])) {
        header("location: misAnuncios.php");
        guardarMensaje("No puedes acceder a este apartado");
        die();
    }

    // Conectamos con la BD
    $connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    // Recuperar el ID del anuncio a editar desde la URL
    $idAnuncio = $_GET["id"];


    // Obtener el anuncio existente
    $anuncioDAO = new AnunciosDAO($conn);
    $anuncio = $anuncioDAO->getAnuncioPorId($idAnuncio);

    // Validar si el anuncio existe y pertenece al usuario actual
    if (!$anuncio || $anuncio->getIdUsuario() !== Sesion::getUsuario()->getEmail()) {
        header("location: misAnuncios.php");
        guardarMensaje("No puedes editar este anuncio");
        die();
    }

    $idAnuncio = $anuncio->getId();
    $idUsuario = $anuncio->getIdUsuario();
    $titulo = $anuncio->getTitulo();
    $descripcion = $anuncio->getDescripcion();
    $fotoPrincipal = $anuncio->getFotoPrincipal();
    $foto2 = $anuncio->getFoto2();  
    $foto3 = $anuncio->getFoto3();
    $foto4 = $anuncio->getFoto4();
    $precio = $anuncio->getPrecio();
    $fecha = $anuncio->getFechaCreacion();
    $vendido = $anuncio->getVendido();

    $error=false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Limpiamos los datos
        $titulo = htmlentities($_POST['titulo']);
        $descripcion = htmlentities($_POST['descripcion']);
        $precio = htmlentities($_POST['precio']);

        //Validacion datos
        if (empty($titulo) || empty($descripcion) || empty($precio)) {

            guardarMensaje("Completa los campos obligatorios");
            $error=true;

        }elseif (strlen($descripcion) > 200){

            guardarMensaje("La descripcion no puede ocupar mas de 200 caracteres");
            $error=true;

        }elseif(!is_numeric($precio)){

            guardarMensaje("El precio debe ser numerico");
            $error=true;

        }else{
            // Constantes para tipos de imagen permitidos
            define('ALLOWED_IMAGE_TYPES', ['image/jpg', 'image/jpeg', 'image/webp', 'image/gif', 'image/png']);

            // Función para validar y mover la foto
            function validarYGuardarFoto($file, $folder)
            {
                global $error;

                if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) {
                    guardarMensaje("Sube un formato valido de imagen ( jpg, jpeg, png, webp, gif )");
                    $error = true;
                    return;
                }

                $nombreArchivo = generarNombreArchivo($file['name']);

                while (file_exists("$folder/$nombreArchivo")) {
                    $nombreArchivo = generarNombreArchivo($file['name']);
                }

                if (!move_uploaded_file($file['tmp_name'], "$folder/$nombreArchivo")) {
                    die("Error al copiar la foto a la carpeta $folder");
                }

                return $nombreArchivo;
            }

            // Validación y manejo de las fotos
            $fotoPrincipalN = isset($_FILES['fotoPrincipal']) && $_FILES['fotoPrincipal']['error'] === UPLOAD_ERR_OK ? validarYGuardarFoto($_FILES['fotoPrincipal'], 'fotosAnuncios') : $fotoPrincipal;
            $foto2N = isset($_FILES['foto2']) && $_FILES['foto2']['error'] === UPLOAD_ERR_OK ? validarYGuardarFoto($_FILES['foto2'], 'fotosAnuncios') : null;
            $foto3N = isset($_FILES['foto3']) && $_FILES['foto3']['error'] === UPLOAD_ERR_OK ? validarYGuardarFoto($_FILES['foto3'], 'fotosAnuncios') : null;
            $foto4N = isset($_FILES['foto4']) && $_FILES['foto4']['error'] === UPLOAD_ERR_OK ? validarYGuardarFoto($_FILES['foto4'], 'fotosAnuncios') : null;

            // Actualizamos en la BD
            if (!$error) {
                if ($anuncioDAO->editarAnuncio($idAnuncio, $titulo, $descripcion, $fotoPrincipalN, $precio, $foto2N, $foto3N, $foto4N)) {
                    header("location: misAnuncios.php");
                    guardarMensajeC("Anuncio editado con éxito");
                    die();
                } else {
                    guardarMensaje("No se ha podido editar el anuncio");
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Anuncio - ShopSwap</title>

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

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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
<body class="p-6 bg-gray-900">

    <!-- Mensaje de error -->    
    <?php imprimirMensaje(); ?>

    <!--JavaScript-->
    <script>
        // Muestra el mensaje de error al cargar la página
        $(document).ready(function () {
              $(".error").fadeIn().delay(5000).fadeOut();
        });
    </script>    

    <!--Formulario de creacion de Anuncio con TailWind, parecido a Bootsrap-->

    <div class="max-w-md mx-auto bg-white rounded-md p-8 shadow-md">

        <!-- Icono en la esquina superior izquierda -->
        <a href="misAnuncios.php" class="fixed top-4 left-4 p-4 text-white flex items-center z-50 rounded-md hover:bg-blue-700 transition-all duration-300">
            <i class="fas fa-arrow-left text-2xl"></i>
        </a>

        
        <h1 class="text-2xl font-semibold mb-6">Editar Anuncio</h1>
        <form action="editarAnuncio.php?id=<?= $anuncio->getId() ?>" method="post" enctype="multipart/form-data">

            <!-- Titulo -->
            <div class="mb-4">
                <label for="titulo" class="block text-sm font-medium text-gray-600">Título</label>
                <input type="text" name="titulo" id="titulo" class="mt-1 p-2 w-full border rounded-md" value="<?= $titulo ?>">
            </div>

            <!--Textarea de JQTextEditor---->
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-600">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="jqte mt-1 p-2 w-full border rounded-md" rows="5"><?= $descripcion ?></textarea>
            </div>

            <!-- Foto Principal -->
            <div class="mb-4">
                <label for="fotoPrincipal" class="block text-sm font-medium text-gray-600">Foto Principal</label>
                <input type="file" name="fotoPrincipal" id="fotoPrincipal" accept="image/jpg, image/jpeg, image/gif, image/webp, image/png" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Foto2 -->
            <div class="mb-4">
                <label for="foto2" class="block text-sm font-medium text-gray-600">Foto 2 (opcional)</label>
                <input type="file" name="foto2" id="foto2" accept="image/jpg, image/jpeg, image/gif, image/webp, image/png" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Foto3 -->
            <div class="mb-4">
                <label for="foto3" class="block text-sm font-medium text-gray-600">Foto 3 (opcional)</label>
                <input type="file" name="foto3" id="foto3" accept="image/jpg, image/jpeg, image/gif, image/webp, image/png" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Foto4 -->
            <div class="mb-4">
                <label for="foto4" class="block text-sm font-medium text-gray-600">Foto 4 (opcional)</label>
                <input type="file" name="foto4" id="foto4" accept="image/jpg, image/jpeg, image/gif, image/webp, image/png" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Precio -->
            <div class="mb-4">
                <label for="precio" class="block text-sm font-medium text-gray-600">Precio</label>
                <div class="relative">
                    <input type="number" name="precio" id="precio" class="mt-1 p-2 w-full border rounded-md" value="<?= $precio ?>">
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                        €
                    </span>
                </div>
            </div>

            <!-- Boton de Enviar -->
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md transition duration-300 ease-in-out transform hover:scale-105">Editar Anuncio</button>
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