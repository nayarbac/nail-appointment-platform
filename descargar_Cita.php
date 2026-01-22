<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos de la cita del formulario
    $id_cita = $_POST['id_cita'];
    $cliente = $_POST['cliente'];
    $nombre_servicio = $_POST['nombre_servicio'];
    $nombre_estilo = $_POST['nombre_estilo'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $precio_total = $_POST['precio_total'];

    // Crear el contenido HTML
    $html_content = "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Detalle de Cita</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                margin: 0;
                padding: 20px;
            }
            .cita-info {
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-bottom: 20px;
            }
            .cita-info p {
                margin: 5px 0;
            }
            .cita-info p strong {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class='cita-info'>
            <h2>Detalle de Cita</h2>
            <p><strong>ID de cita:</strong> $id_cita</p>
            <p><strong>Cliente:</strong> $cliente</p>
            <p><strong>Nombre del servicio:</strong> $nombre_servicio</p>
            <p><strong>Nombre del estilo:</strong> $nombre_estilo</p>
            <p><strong>Fecha:</strong> $fecha</p>
            <p><strong>Hora:</strong> $hora</p>
            <p><strong>Precio total:</strong> $" . number_format($precio_total, 2) . "</p>
        </div>
    </body>
    </html>
    ";

    // Definir el nombre del archivo
    $filename = "cita_$id_cita.html";

    // Configurar las cabeceras para forzar la descarga del archivo
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$filename");

    // Imprimir el contenido HTML para descargar
    echo $html_content;
} else {
    // Si no se ha enviado el formulario, redireccionar a la página anterior
    header("Location: index.php"); // Cambia "index.php" al nombre de tu página principal
    exit();
}
?>
