<!-- filepath: c:\xampp\htdocs\xampp\Pagina PHP\Medicion.php -->
<?php
require_once 'Database.php';

class Medicion {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function obtenerDatos($fecha_hora_inicio, $fecha_hora_fin, $orden) {
        $sql = "SELECT temperatura, humedad, fecha FROM mediciones 
                WHERE fecha BETWEEN ? AND ? ORDER BY fecha $orden";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $fecha_hora_inicio, $fecha_hora_fin);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $datos = [];
        while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }
        return $datos;
    }
}
?>