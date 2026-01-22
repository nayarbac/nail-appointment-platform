<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualización de Detalle de Citas</title>
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
            position: relative; /* Agregado */
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
            background-color: #c74e88; /* Fondo rosa oscuro */
            color: #fff; /* Letras blancas */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Fondo gris claro alternado */
        }
        .btn-regresar {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #c74e88;
            border-color: #c74e88;
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
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
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
        }
        .btn-detalle:hover {
            background-color: #a04174;
            border-color: #a04174;
        }
    </style>
</head>
<body>

<a href="javascript:history.back()" class="btn btn-regresar">Regresar</a>

<div class="container mt-4">
    <h2>Detalle de Citas</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Detalle</th>
                <th>ID Cita</th>
                <th>Cliente</th>
                <th>ID Cliente</th>
                <th>Nombre Servicio</th>
                <th>Nombre Estilo</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Precio Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Establecer conexión a la base de datos
            $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

            // Verificar la conexión
            if ($conexion->connect_error) {
                die("Error al conectar con la base de datos: " . $conexion->connect_error);
            }

            // Consulta SQL para seleccionar todos los registros de la tabla detalle_cita
            $sql = "SELECT * FROM detalle_cita";

            // Ejecutar la consulta
            $resultado = $conexion->query($sql);

            // Verificar si hay resultados de la consulta
            if ($resultado->num_rows > 0) {
                // Iterar sobre cada fila de resultados
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila["id_detalle"] . "</td>";
                    echo "<td>" . $fila["id_cita"] . "</td>";
                    echo "<td>" . $fila["cliente"] . "</td>";
                    echo "<td>" . $fila["id_cliente"] . "</td>";
                    echo "<td>" . $fila["nombre_servicio"] . "</td>";
                    echo "<td>" . $fila["nombre_estilo"] . "</td>";
                    echo "<td>" . $fila["fecha"] . "</td>";
                    echo "<td>" . $fila["hora"] . "</td>";
                    echo "<td>" . $fila["precio_total"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No hay detalles de citas registrados.</td></tr>";
            }

            // Cerrar la conexión
            $conexion->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

