<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Datos del Cliente</title>
</head>
<body>
    <h1>Datos de la Cita</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servicio = $_POST["servicio"];
        $estilo = $_POST["estilo"];
        $precioEstilo = $_POST["precioEstilo"];
        $fecha = $_POST["fecha"];
        $hora = $_POST["hora"];
        
        echo "<p>Servicio: $servicio</p>";
        echo "<p>Estilo: $estilo</p>";
        echo "<p>Precio del Estilo: $precioEstilo</p>";
        echo "<p>Fecha: $fecha</p>";
        echo "<p>Hora: $hora</p>";
    } else {
        echo "<p>No se recibieron datos del formulario.</p>";
    }
    ?>
</body>
</html>
