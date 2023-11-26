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
  guardarMensaje("No puedes comprar productos si no has iniciado sesion");
  die();
}

// Seguridad
if (!isset($_GET["id"])) {
  header("location: index.php");
  guardarMensaje("No puedes acceder a este apartado");
  die();
}

// Creamos la conexión utilizando la clase que hemos creado
$connexionDB = new ConexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
$conn = $connexionDB->getConnexion();

//Creamos el objeto anuncioDAO para acceder a BDD
$anuncioDAO = new AnunciosDAO($conn);
$anuncio = $anuncioDAO->getAnuncioPorId($_GET["id"]);

if (Sesion::getUsuario()->getEmail() == $anuncio->getIdUsuario()) {
  header("location: index.php");
  guardarMensaje("No puedes comprar tu producto");
  die();
} elseif ($anuncio->getVendido() == 1) {
  header("location: index.php");
  guardarMensaje("Este producto esta vendido");
  die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if ($anuncioDAO->venderAnuncio($anuncio->getId(), Sesion::getUsuario()->getEmail())) {
    header("location: index.php");
    guardarMensajeC("Producto comprado con exito");
    die();
  } else {
    header("location: index.php");
    guardarMensaje("Error al comprar el anuncio");
    die();
  }
}

// Cerrar la conexión a la base de datos (puedes hacerlo después de utilizarla)
$connexionDB->cerrarConexion();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comprar - ShopSwap</title>

  <!-- Tailwind -->
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
  <script defer src="https://unpkg.com/alpinejs@3.2.2/dist/cdn.min.js"></script>

  <!-- FontAwesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <!--Iconos para la web-->
  <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
  <link rel="manifest" href="images/site.webmanifest">

  <style>
    .form-select {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 0.5rem center;
      background-size: 1.5em 1.5em;
      -webkit-tap-highlight-color: transparent;
    }

    .submit-button:disabled {
      cursor: not-allowed;
      background-color: #D1D5DB;
      color: #111827;
    }

    .submit-button:disabled:hover {
      background-color: #9CA3AF;
    }

    .credit-card {
      max-width: 420px;
      margin-top: 3rem;
    }

    @media only screen and (max-width: 420px) {
      .credit-card .front {
        font-size: 100%;
        padding: 0 2rem;
        bottom: 2rem !important;
      }

      .credit-card .front .number {
        margin-bottom: 0.5rem !important;
      }
    }
  </style>
</head>

<body class="bg-gray-500">

  <!-- Icono en la esquina superior izquierda -->
  <a href="verAnuncio.php?id=<?= $anuncio->getId() ?>&ruta=index.php"
    class="fixed top-4 left-4 p-4 text-white flex items-center z-50 rounded-md hover:bg-blue-700 transition-all duration-300">
    <i class="fas fa-arrow-left text-2xl"></i>
  </a>

  <div class="m-4">
    <div class="credit-card w-full sm:w-auto shadow-lg mx-auto rounded-xl bg-white" x-data="creditCard">
      <header class="flex flex-col justify-center items-center">
        <div class="relative" x-show="card === 'front'" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-90"
          x-transition:enter-end="opacity-100 transform scale-100">
          <img class="w-full h-auto"
            src="https://www.computop-paygate.com/Templates/imagesaboutYou_desktop/images/svg-cards/card-visa-front.png"
            alt="front credit card">
          <div class="front bg-transparent text-lg w-full text-white px-12 absolute left-0 bottom-12">
            <p class="number mb-5 sm:text-xl" x-text="cardNumber !== '' ? cardNumber : '0000 0000 0000 0000'"></p>
            <div class="flex flex-row justify-between">
              <p x-text="cardholder !== '' ? cardholder : 'Titular de la tarjeta'"></p>
              <div class="">
                <span x-text="expired.month"></span>
                <span x-show="expired.month !== ''">/</span>
                <span x-text="expired.year"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="relative" x-show="card === 'back'" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-90"
          x-transition:enter-end="opacity-100 transform scale-100">
          <img class="w-full h-auto"
            src="https://www.computop-paygate.com/Templates/imagesaboutYou_desktop/images/svg-cards/card-visa-back.png"
            alt="">
          <div
            class="bg-transparent text-white text-xl w-full flex justify-end absolute bottom-20 px-8  sm:bottom-24 right-0 sm:px-12">
            <div class="border border-white w-16 h-9 flex justify-center items-center">
              <p x-text="securityCode !== '' ? securityCode : 'CVC'"></p>
            </div>
          </div>
        </div>
        <ul class="flex">
          <li class="mx-2">
            <img class="w-16"
              src="https://www.computop-paygate.com/Templates/imagesaboutYou_desktop/images/computop.png" alt="" />
          </li>
          <li class="mx-2">
            <img class="w-14"
              src="https://www.computop-paygate.com/Templates/imagesaboutYou_desktop/images/verified-by-visa.png"
              alt="" />
          </li>
          <li class="ml-5">
            <img class="w-7"
              src="https://www.computop-paygate.com/Templates/imagesaboutYou_desktop/images/mastercard-id-check.png"
              alt="" />
          </li>
        </ul>
      </header>
      <main class="mt-4 p-4">
        <h1 class="text-xl font-semibold text-gray-700 text-center">Pago con tarjeta</h1>
        <div class="">
          <div class="my-3">
            <input type="text"
              class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:outline-none"
              placeholder="Titular de la tarjeta" maxlength="22" x-model="cardholder" />
          </div>
          <div class="my-3">
            <input type="text"
              class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:outline-none"
              placeholder="Numero de tarjeta" x-model="cardNumber" x-on:keydown="format()" x-on:keyup="isValid()"
              maxlength="19" />
          </div>
          <div class="my-3 flex flex-col">
            <div class="mb-2">
              <label for="" class="text-gray-700">Fecha de expiración</label>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
              <select name="" id=""
                class="form-select appearance-none block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:outline-none"
                x-model="expired.month">
                <option value="" selected disabled>MM</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
              <select name="" id=""
                class="form-select appearance-none block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:outline-none"
                x-model="expired.year">
                <option value="" selected disabled>YY</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
              </select>
              <input type="text"
                class="block w-full col-span-2 px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:outline-none"
                placeholder="CVC" maxlength="3" x-model="securityCode" x-on:focus="card = 'back'"
                x-on:blur="card = 'front'" />
            </div>
          </div>
        </div>
      </main>
      <footer class="mt-6 p-4">
        <form action="comprarAnuncio.php?id=<?= $anuncio->getId() ?>" method="post">
          <button
            class="submit-button px-4 py-3 rounded-full bg-blue-300 text-blue-900 focus:ring focus:outline-none w-full text-xl font-semibold transition-colors"
            x-bind:disabled="!isValid" x-on:click="onSubmit()">
            Pague ahora
          </button>
        </form>

      </footer>
    </div>
  </div>
  <script>
    document.addEventListener("alpine:init", () => {
      Alpine.data("creditCard", () => ({
        init() {
          console.log('Component mounted');
        },
        format() {
          if (this.cardNumber.length > 18) {
            return;
          }
          this.cardNumber = this.cardNumber.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
        },
        get isValid() {
          if (this.cardholder.length < 5) {
            return false;
          }
          if (this.cardNumber === '') {
            return false;
          }
          if (this.expired.month === '' && this.expired.year === '') {
            return false;
          }
          if (this.securityCode.length !== 3) {
            return false;
          }
          return true;
        },
        cardholder: '',
        cardNumber: '',
        expired: {
          month: '',
          year: '',
        },
        securityCode: '',
        card: 'front',
      }));
    });
  </script>
</body>

</html>