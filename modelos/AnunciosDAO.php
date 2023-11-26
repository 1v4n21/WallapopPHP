<?php

class AnunciosDAO{
    private mysqli $conn;

    // Constructor
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Método para crear un nuevo anuncio
    public function crearAnuncio($idUsuario, $titulo, $descripcion, $fotoPrincipal, $precio, $vendido, $foto2, $foto3 , $foto4) {
        // Construimos la consulta SQL con las columnas opcionales
        $sql = "INSERT INTO anuncios (idUsuario, titulo, descripcion, foto_principal, precio, vendido, foto2, foto3, foto4) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if (!$stmt = $this->conn->prepare($sql)) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Vinculamos los parámetros
        $stmt->bind_param("sssssssss", $idUsuario, $titulo, $descripcion, $fotoPrincipal, $precio, $vendido, $foto2, $foto3, $foto4);

        if($stmt->execute()){
            return $stmt->insert_id;
        }

        else{
            return false;
        }
    }

    //Metodo para editar anuncio
    public function editarAnuncio($idAnuncio, $titulo, $descripcion, $fotoPrincipal, $precio, $foto2, $foto3, $foto4) {
        // Construimos la consulta SQL con las columnas opcionales
        $sql = "UPDATE anuncios SET titulo=?, descripcion=?, foto_principal=?, precio=?, foto2=?, foto3=?, foto4=? WHERE id=?";
    
        if (!$stmt = $this->conn->prepare($sql)) {
            echo "Error en la SQL: " . $this->conn->error;
        }
    
        // Vinculamos los parámetros
        $stmt->bind_param("sssssssi", $titulo, $descripcion, $fotoPrincipal, $precio, $foto2, $foto3, $foto4, $idAnuncio);
    
        return $stmt->execute();
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
    public function getAnunciosPorUsuario($idUsuario, $inicio): array {
        // Preparar la consulta SQL
        if (!$stmt = $this->conn->prepare("SELECT * FROM anuncios WHERE idUsuario = ? ORDER BY fecha_creacion DESC LIMIT ?, 5")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
    
        // Vincular el parámetro
        $stmt->bind_param("si", $idUsuario , $inicio);
    
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

    //Obtener el total de anuncios de un usuario
    public function getTotalAnunciosUsuario($idUsuario): int {
        // Preparar la consulta SQL
        if (!$stmt = $this->conn->prepare("SELECT COUNT(*) FROM anuncios WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s',$idUsuario);
    
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

    //Obtener las compras del usuario logueado
    public function getComprasPorUsuario($idUsuario, $inicio): array {
        // Preparar la consulta SQL
        if (!$stmt = $this->conn->prepare("SELECT * FROM anuncios WHERE idComprador = ? AND vendido=1 ORDER BY fecha_creacion DESC LIMIT ?, 5")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
    
        // Vincular el parámetro
        $stmt->bind_param("si", $idUsuario , $inicio);
    
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

    //Obtener el total de comprasde un usuario
    public function getTotalComprasUsuario($idUsuario): int {
        // Preparar la consulta SQL
        if (!$stmt = $this->conn->prepare("SELECT COUNT(*) FROM anuncios WHERE idComprador = ? AND vendido=1")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s',$idUsuario);
    
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

    //Obtiene un anuncio por su id
    public function getAnuncioPorId($idAnuncio): Anuncio {
        // Preparar la consulta SQL
        if (!$stmt = $this->conn->prepare("SELECT * FROM anuncios WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
    
        // Vincular el parámetro
        $stmt->bind_param("i", $idAnuncio);
    
        // Ejecutar la consulta SQL
        $stmt->execute();
    
        // Obtener el resultado
        $result = $stmt->get_result();
    
        // Obtener el objeto Anuncio
        $anuncio = $result->fetch_object(Anuncio::class);
    
        // Cerrar la declaración
        $stmt->close();
    
        return $anuncio;
    }

    //Elimina un anuncio por su id
    public function eliminarAnuncioPorId($idAnuncio): bool {
        // Preparar la consulta SQL
        if (!$stmt = $this->conn->prepare("DELETE FROM anuncios WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
            return false;
        }
    
        // Vincular el parámetro
        $stmt->bind_param("i", $idAnuncio);
    
        // Ejecutar la consulta SQL
        $result = $stmt->execute();
    
        // Cerrar la declaración
        $stmt->close();
    
        return $result;
    }

    //Obtener las fotos de un anuncio para eliminarlas tambien
    public function obtenerNombresFotosPorIdAnuncio($idAnuncio): array {
        // Preparar la consulta SQL
        if (!$stmt = $this->conn->prepare("SELECT foto_principal, foto2, foto3, foto4 FROM anuncios WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
    
        // Vincular el parámetro
        $stmt->bind_param("i", $idAnuncio);
    
        // Ejecutar la consulta SQL
        $stmt->execute();
    
        // Obtener el resultado
        $result = $stmt->get_result();
    
        // Obtener nombres de fotos
        $fila = $result->fetch_assoc();
    
        // Cerrar la declaración
        $stmt->close();
    
        // Filtrar valores nulos y devolver un array con los nombres de las fotos
        return array_filter($fila);
    }

    //Elimina las fotos asociadas a un anuncio llamando al metodo anterior
    public function eliminarFotosAnuncio($idAnuncio): void {
        // Obtener nombres de fotos de la base de datos
        $nombresFotos = $this->obtenerNombresFotosPorIdAnuncio($idAnuncio);
    
        // Carpeta donde se almacenan las fotos
        $carpetaFotos = "fotosAnuncios/";
    
        // Iterar sobre los nombres de las fotos y eliminar cada archivo
        foreach ($nombresFotos as $nombreFoto) {
            $rutaFoto = $carpetaFotos . $nombreFoto;
            if (file_exists($rutaFoto)) {
                unlink($rutaFoto);
            }
        }
    }
}