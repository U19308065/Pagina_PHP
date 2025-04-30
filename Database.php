<?php
class Database {
    private $conn;

    // Constructor que recibe los parámetros de conexión
    public function __construct($host, $user, $password, $dbname, $port = 3306) {
        $this->conn = new mysqli($host, $user, $password, $dbname, $port);
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // Método para obtener la conexión
    public function getConnection() {
        return $this->conn;
    }

    // Método para cerrar la conexión
    public function closeConnection() {
        $this->conn->close();
    }
}
?>