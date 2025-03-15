<!-- filepath: c:\xampp\htdocs\xampp\Pagina PHP\getData.php -->
<?php
require_once 'Medicion.php';

header('Content-Type: application/json');

$fecha_actual = date('Y-m-d');
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : "$fecha_actual 00:00:00";
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : "$fecha_actual 23:59:59";
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'ASC';

$medicion = new Medicion();
$datos = $medicion->obtenerDatos($fecha_inicio, $fecha_fin, $orden);

echo json_encode($datos);
?>