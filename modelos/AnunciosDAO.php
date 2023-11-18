<?php

class AnunciosDAO{
    private mysqli $conn;

    // Constructor
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Método para crear un nuevo anuncio
    public function crearAnuncio($idUsuario, $titulo, $descripcion, $fotoPrincipal, $precio, $fechaCreacion, $vendido, $foto2 = null, $foto3 = null, $foto4 = null) {
        // Construimos la consulta SQL con las columnas opcionales
        $sql = "INSERT INTO anuncios (idUsuario, titulo, descripcion, foto_principal, precio, vendido, foto2, foto3, foto4) VALUES (?, ?, ?, ?, , ?, ?, ?, ?, ?)";

        if (!$stmt = $this->conn->prepare($sql)) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Vinculamos los parámetros
        $stmt->bind_param("issssssss", $idUsuario, $titulo, $descripcion, $fotoPrincipal, $precio, $vendido, $foto2, $foto3, $foto4);

        // Ejecutamos la SQL
        if (!$stmt->execute()) {
            echo "Error al ejecutar la SQL: " . $stmt->error;
        }

        // Cerramos la declaración
        $stmt->close();
    }

    // Método para obtener todos los anuncios vendidos
    public function getAnunciosVendidos(): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM anuncios WHERE vendido = true")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Ejecutamos la SQL
        $stmt->execute();

        // Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_anuncios = array();

        while ($anuncio = $result->fetch_object(Anuncio::class)) {
            $array_anuncios[] = $anuncio;
        }

        return $array_anuncios;
    }

    // Método para obtener todos los anuncios no vendidos
    public function getAnunciosNoVendidos(): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM anuncios WHERE vendido = false")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Ejecutamos la SQL
        $stmt->execute();

        // Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_anuncios = array();

        while ($anuncio = $result->fetch_object(Anuncio::class)) {
            $array_anuncios[] = $anuncio;
        }

        return $array_anuncios;
    }
}