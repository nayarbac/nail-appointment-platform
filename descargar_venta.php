<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos de la venta del formulario
    $ID_venta = $_POST['ID_venta'];
    $fecha = $_POST['fecha'];
    $nombre_producto = $_POST['nombre_producto'];
    $cantidad = $_POST['cantidad'];
    $total_venta = $_POST['total_venta'];
    $hora = $_POST['hora'];
    $usuario = $_POST['usuario'];

    // Crear el contenido HTML
    $html_content = "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Detalle de Venta</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                margin: 0;
                padding: 20px;
            }
            .venta-info {
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-bottom: 20px;
            }
            .venta-info p {
                margin: 5px 0;
            }
            .venta-info p strong {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class='venta-info'>
            <h2>Detalle de Venta</h2>
            <p><strong>ID de venta:</strong> $ID_venta</p>
            <p><strong>Fecha:</strong> $fecha</p>
            <p><strong>Producto:</strong> $nombre_producto</p>
            <p><strong>Cantidad:</strong> $cantidad</p>
            <p><strong>Total de la venta:</strong> $" . number_format($total_venta, 2) . "</p>
            <p><strong>Hora:</strong> $hora</p>
            <p><strong>Usuario:</strong> $usuario</p>
        </div>
    </body>
    </html>
    ";

    // Definir el nombre del archivo
    $filename = "venta_$ID_venta.html";

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
