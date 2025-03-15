<?php
require_once 'Medicion.php';
include 'header.php';
include 'sidebar.php';
// Establecer la zona horaria a UTC-5 (Lima, Perú)
date_default_timezone_set('America/Lima');
$medicion = new Medicion();
$view = $_GET['view'] ?? 'temperatura';
// Obtener los parámetros de fecha y hora del filtro
$fecha_inicio = $_GET['fecha_inicio'] ?? date('Y-m-d');
$fecha_fin = $_GET['fecha_fin'] ?? date('Y-m-d');
$hora_inicio = $_GET['hora_inicio'] ?? '00:00';
$hora_fin = $_GET['hora_fin'] ?? '23:59';
$fecha_hora_inicio = "$fecha_inicio $hora_inicio";
$fecha_hora_fin = "$fecha_fin $hora_fin";
$datos = $medicion->obtenerDatos($fecha_hora_inicio, $fecha_hora_fin, 'ASC');
function mostrarGrafico($datos, $tipo) {
    $labels = [];
    $data = [];
    foreach ($datos as $dato) {
        $labels[] = $dato['fecha'];
        $data[] = $dato[$tipo];
    }
    $labels = json_encode($labels);
    $data = json_encode($data);
    echo "<h2>Gráfico de $tipo</h2>";
    echo "<canvas id='grafico'></canvas>";
    echo "<script>
        var ctx = document.getElementById('grafico').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: $labels,
                datasets: [{
                    label: '$tipo',
                    data: $data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'hour'
                        },
                        adapters: {
                            date: {
                                locale: window.dateFnsLocaleEs
                            }
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>";
}
function mostrarValores($datos) {
    echo "<h2>Valores</h2>";
    echo "<table class='table'><thead><tr><th>Fecha</th><th>Temperatura</th><th>Humedad</th></tr></thead><tbody>";
    foreach ($datos as $dato) {
        echo "<tr><td>{$dato['fecha']}</td><td>{$dato['temperatura']}</td><td>{$dato['humedad']}</td></tr>";
    }
    echo "</tbody></table>";
}
?>
<style>
    .input-pequeño {
        width: 150px; /* Ajusta el ancho según sea necesario */
    }
</style>
<div class="col-md-10">
    <form method="GET" action="index.php" class="row g-3">
        <input type="hidden" name="view" value="<?php echo $view; ?>">
        <div class="col-md-3">
            <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control form-control-sm input-pequeño" value="<?php echo $fecha_inicio; ?>">
        </div>
        <div class="col-md-3">
            <label for="hora_inicio" class="form-label">Hora Inicio:</label>
            <input type="time" id="hora_inicio" name="hora_inicio" class="form-control form-control-sm input-pequeño" value="<?php echo $hora_inicio; ?>">
        </div>
        <div class="col-md-3">
            <label for="fecha_fin" class="form-label">Fecha Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control form-control-sm input-pequeño" value="<?php echo $fecha_fin; ?>">
        </div>
        <div class="col-md-3">
            <label for="hora_fin" class="form-label">Hora Fin:</label>
            <input type="time" id="hora_fin" name="hora_fin" class="form-control form-control-sm input-pequeño" value="<?php echo $hora_fin; ?>">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
        </div>
    </form>
    <?php
    switch ($view) {
        case 'temperatura':
            mostrarGrafico($datos, 'temperatura');
            break;
        case 'humedad':
            mostrarGrafico($datos, 'humedad');
            break;
        case 'ambos':
            echo "<h2>Gráfico de temperatura y humedad</h2>";
            echo "<canvas id='grafico'></canvas>";
            $labels = json_encode(array_column($datos, 'fecha'));
            $temperatura = json_encode(array_column($datos, 'temperatura'));
            $humedad = json_encode(array_column($datos, 'humedad'));
            echo "<script>
                var ctx = document.getElementById('grafico').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: $labels,
                        datasets: [
                            {
                                label: 'Temperatura',
                                data: $temperatura,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                                fill: false,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Humedad',
                                data: $humedad,
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1,
                                fill: false,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'hour'
                                },
                                adapters: {
                                    date: {
                                        locale: window.dateFnsLocaleEs
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Temperatura'
                                }
                            },
                            y1: {
                                beginAtZero: true,
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false
                                },
                                title: {
                                    display: true,
                                    text: 'Humedad'
                                }
                            }
                        }
                    }
                });
            </script>";
            break;
        case 'valores':
            mostrarValores($datos);
            break;
        default:
            echo "<p>Seleccione una opción del menú.</p>";
    }
    ?>
</div>
<?php
include 'footer.php';
?>