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

    // Método para obtener todos los anuncios no vendidos paginacion
    public function getAnunciosNoVendidosP($inicio): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM anuncios WHERE vendido = false ORDER BY fecha_creacion DESC LIMIT ?, 5")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Vincular los parámetros de la consulta
        $stmt->bind_param("i", $inicio);

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

    //Obtener la cantidad de anuncios no vendidos existentes
    public function getTotalAnunciosNoVendidos(): int {
        // Preparar la consulta SQL
        if (!$stmt = $this->conn->prepare("SELECT COUNT(*) FROM anuncios WHERE vendido = false")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
    
        // Ejecutar la consulta SQL
        $stmt->execute();
    
        // Obtener el resultado
        $stmt->bind_result($totalAnuncios);
    
        // Recuperar el valor
        $stmt->fetch();
    
        // Cerrar la declaración
        $stmt->close();
    
        return $totalAnuncios;
    }

    //Obtener los anuncios del usuario logueado
    public function getAnunciosPorUsuario($idUsuario): array {
        // Preparar la consulta SQL
        if (!$stmt = $this->conn->prepare("SELECT * FROM anuncios WHERE IdUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
    
        // Vincular el parámetro
        $stmt->bind_param("s", $idUsuario);
    
        // Ejecutar la consulta SQL
        $stmt->execute();
    
        // Obtener el resultado
        $result = $stmt->get_result();
    
        $arrayAnuncios = array();
    
        // Recorrer los resultados y almacenar en un array
        while ($anuncio = $result->fetch_object(Anuncio::class)) {
            $arrayAnuncios[] = $anuncio;
        }
    
        // Cerrar la declaración
        $stmt->close();
    
        return $arrayAnuncios;
    }
    
}