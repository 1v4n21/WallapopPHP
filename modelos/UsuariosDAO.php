<?php

class UsuariosDAO
{
    private mysqli $conn;

    // Constructor
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Método para insertar un usuario
    public function insert(Usuario $usuario): int|bool
    {
        $sql = "INSERT INTO usuarios (sid, email, password, nombre, telefono, poblacion) VALUES (?, ?, ?, ?, ?, ?)";

        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }

        $sid = $usuario->getSid();
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();
        $nombre = $usuario->getNombre();
        $telefono = $usuario->getTelefono();
        $poblacion = $usuario->getPoblacion();

        $stmt->bind_param('ssssis', $sid, $email, $password, $nombre, $telefono, $poblacion);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    //Obtener por email
    public function getByEmail($email): Usuario|null
    {

        if (!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s', $email);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Mensaje, sino null
        if ($result->num_rows >= 1) {
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        } else {
            return null;
        }
    }

    //Obtener por sid
    public function getBySid($sid): Usuario|null
    {

        if (!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE sid = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Asociar las variables a las interrogaciones (parámetros)
        $stmt->bind_param('s', $sid);

        // Ejecutamos la SQL
        $stmt->execute();

        // Obtener el objeto mysql_result
        $result = $stmt->get_result();

        // Si ha encontrado algún resultado devolvemos un objeto de la clase Usuario, sino null
        if ($result->num_rows >= 1) {
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        } else {
            return null;
        }
    }
}

?>