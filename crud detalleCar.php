<?php
// Establecer conexión a la base de datos
$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

// Consulta SQL para seleccionar los elementos del carrito
$sql = "SELECT * FROM carrito";

// Ejecutar la consulta y almacenar los resultados en $resultado
$resultado = $conexion->query($sql);

// Cerrar la conexión
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualización de Carrito</title>
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
            position: relative;
        }
        h2 {
            margin-bottom: 20px;
            color: #c74e88; /* Letras rosadas */
        }
        table {
            background-color: #f9f3f3; /* Fondo blanco rosáceo */
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #c74e88; /* Rosa fuerte */
            color: #fff; /* Letras blancas */
        }
        tr:nth-child(even) {
            background-color: #fce8e8; /* Rosa pálido alternado */
        }
        .regresar-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #ff92b3; /* Rosa claro */
            color: #fff; /* Letras blancas */
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .detalle-carrito-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #c74e88; /* Rosa fuerte */
            color: #fff; /* Letras blancas */
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <a href="javascript:history.go(-1)" class="regresar-btn">Regresar</a>
    <div class="container mt-4">
        <h2>Lista de Carrito</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Carrito</th>
                    <th>Estado</th>
                    <th>Fecha de Creación</th>
                    <th>Total del Carrito</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar si hay resultados de la consulta
                if ($resultado->num_rows > 0) {
                    // Iterar sobre cada fila de resultados
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $fila["id_carrito"] . "</td>";
                        echo "<td>" . $fila["estado"] . "</td>";
                        echo "<td>" . $fila["fecha_creacion"] . "</td>";
                        echo "<td>" . $fila["total_carrito"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay registros en el carrito.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="cruddetalleC.php" class="detalle-carrito-btn">Detalle del Carrito</a>
    </div>
</body>
</html>
