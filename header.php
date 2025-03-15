<!-- filepath: c:\xampp\htdocs\xampp\Pagina PHP\header.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediciones</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src="https://cdn.jsdelivr.net/npm/date-fns/locale/es/index.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container-fluid {
            flex: 1;
        }
        .sidebar {
            padding: 10px;
        }
        .list-group-item {
            cursor: pointer;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="#">
        <img src="logo.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
        Mediciones
    </a>
</nav>
<div class="container-fluid">
    <div class="row">