<?php

$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

$sql = "SELECT * FROM ventas";
$resultado = $conexion->query($sql);

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualización de Ventas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #fdd; /* Fondo rosa */
            padding-top: 20px;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            background-color: #fff; /* Fondo blanco */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #c74e88; /* Letras rosadas */
        }
        table {
            background-color: #fff; /* Fondo blanco */
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #c74e88; 
            color: #fff; /* Letras blancas */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; 
        }
        .btn-regresar {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #c74e88;
            border-color: #c74e88;
        }
        .btn-regresar:hover {
            background-color: #a04174;
            border-color: #a04174;
        }
        .btn-detalle {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #c74e88;
            border-color: #c74e88;
        }
        .btn-detalle:hover {
            background-color: #a04174;
            border-color: #a04174;
        }
    </style>
</head>
<body>
    <a href="javascript:history.back()" class="btn btn-regresar text-white">Regresar</a>
    <a href="cruddetalleventa.php" class="btn btn-detalle text-white">Detalle de Venta</a>
    <div class="container mt-4">
        <h2>Lista de Ventas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Fecha</th>
                    <th>Total Venta</th>
                    <th>Método de Pago</th>
                    <th>Nombre Producto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $fila["ID_venta"] . "</td>";
                        echo "<td>" . $fila["fecha"] . "</td>";
                        echo "<td>" . $fila["total_venta"] . "</td>";
                        echo "<td>" . $fila["metodo_pago"] . "</td>";
                        echo "<td>" . $fila["nombre_producto"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay ventas registradas.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
