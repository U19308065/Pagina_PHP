<?php
require_once 'Database.php';

// Configuración de la base de datos remota (origen)
$remoteHost = 'sql10.freesqldatabase.com';
$remoteDb = 'sql10776098';
$remoteUser = 'sql10776098';
$remotePass = 'VjnjzUHzil';
$remotePort = 3306;

// Configuración de la base de datos local (destino)
$localHost = 'sql301.byethost9.com';
$localDb = 'b9_38425474_mediciones';
$localUser = 'b9_38425474';
$localPass = 'Mahumali&2022';

// Crear conexiones usando la clase Database
$remoteDatabase = new Database($remoteHost, $remoteUser, $remotePass, $remoteDb, $remotePort);
$localDatabase = new Database($localHost, $localUser, $localPass, $localDb);

// Obtener las conexiones
$remoteConn = $remoteDatabase->getConnection();
$localConn = $localDatabase->getConnection();

// Consulta para obtener los datos de la base de datos remota
$query = "SELECT * FROM mediciones"; // Cambia "mediciones" por el nombre de tu tabla
$result = $remoteConn->query($query);

if ($result && $result->num_rows > 0) {
    // Limpia la tabla local antes de insertar los datos
    $localConn->query("TRUNCATE TABLE mediciones");

    // Inserta los datos en la base de datos local
    while ($row = $result->fetch_assoc()) {
        $fecha = $localConn->real_escape_string($row['fecha']);
        $temperatura = $localConn->real_escape_string($row['temperatura']);
        $humedad = $localConn->real_escape_string($row['humedad']);

        $insertQuery = "INSERT INTO mediciones (fecha, temperatura, humedad) 
                        VALUES ('$fecha', '$temperatura', '$humedad')";
        $localConn->query($insertQuery);
    }
    //echo "Respaldo completado con éxito.";
} else {
    //echo "No se encontraron datos en la base de datos remota.";
}

// Cierra las conexiones
$remoteDatabase->closeConnection();
$localDatabase->closeConnection();
?>