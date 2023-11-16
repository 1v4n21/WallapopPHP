<?php 

class ConexionDB{

    private $conn;
    
    //Constructor
    function __construct($user, $password, $host, $database)
    {
        $this->conn = new mysqli($host,$user,$password,$database);
        if($this->conn->connect_error){
            die('Error al conectar con MySQL');
        }
    }

    //Obtener conexion de la DB
    function getConnexion(){
        return $this->conn;
    }
} 