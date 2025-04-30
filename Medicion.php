<?php
require_once 'Database.php';

class Medicion {
    private $db;

    public function __construct() {
        // Incluir el archivo de configuración
        $config = require 'config.php';

        // Crear una instancia de la clase Database con las credenciales locales
        $this->db = new Database($config['local']);
    }

    public function obtenerDatos($fechaInicio, $fechaFin, $orden = 'ASC') {
        $conn = $this->db->getConnection();
        $query = "SELECT * FROM mediciones WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY fecha $orden";
        $result = $conn->query($query);

        $datos = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $datos[] = $row;
            }
        }
        return $datos;
    }
}
?>