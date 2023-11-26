<?php

class ConexionDB
{
    private $conn;

    // Constructor
    public function __construct($user, $password, $host, $database)
    {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die('Error al conectar con MySQL');
        }
    }

    // Obtener conexión de la DB
    public function getConnexion()
    {
        return $this->conn;
    }

    // Cerrar conexión
    public function cerrarConexion()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>