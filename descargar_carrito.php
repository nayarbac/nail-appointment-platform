<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del carrito del formulario
    $id_detalle = $_POST['id_detalle'];
    $id_carrito = $_POST['id_carrito'];
    $id_cliente = $_POST['id_cliente'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $cantidad = $_POST['cantidad'];
    $precio_unitario = $_POST['precio_unitario'];
    $total = $_POST['total'];

    // Crear el contenido HTML para la nota del carrito
    $html_content = "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Detalle de Carrito</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #FFD6E9; /* Fondo rosado */
                color: #FF6BBD; /* Color de texto rosa */
                margin: 0;
                padding: 0;
            }   
            
            .container {
                max-width: 800px;
                margin: 50px auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                position: relative;
            }

            h1 {
                text-align: center;
                margin-bottom: 30px;
                color: #FF6BBD; /* Color de texto rosa */
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Detalle de Carrito</h1>
            <table>
                <tr>
                    <th>ID Detalle</th>
                    <th>ID Carrito</th>
                    <th>ID Cliente</th>
                    <th>Nombre Cliente</th>
                    <th>ID Producto</th>
                    <th>Nombre Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>$id_detalle</td>
                    <td>$id_carrito</td>
                    <td>$id_cliente</td>
                    <td>$nombre_cliente</td>
                    <td>$id_producto</td>
                    <td>$nombre_producto</td>
                    <td>$cantidad</td>
                    <td>$precio_unitario</td>
                    <td>$total</td>
                </tr>
            </table>
        </div>
    </body>
    </html>
    ";

    // Definir el nombre del archivo
    $filename = "nota_de_carrito_$id_carrito.html";

    // Configurar las cabeceras para forzar la descarga del archivo
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$filename");

    // Imprimir el contenido HTML para descargar
    echo $html_content;
} else {
    // Si no se ha enviado el formulario, redireccionar a la página principal
    header("Location: index.php"); // Cambia "index.php" al nombre de tu página principal
    exit();
}
?>
