<?php
class Database {
    private $conn;

    // Constructor que recibe las credenciales como un array
    public function __construct($config) {
        $this->conn = new mysqli(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['dbname'],
            $config['port']
        );
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