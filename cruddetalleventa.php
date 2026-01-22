<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Venta</title>
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
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>
<body>

<a href="javascript:history.back()" class="btn btn-regresar">Regresar</a>

<div class="container mt-4">
    <h2>Detalle de Venta</h2>

    <table>
        <thead>
            <tr>
                <th>ID Detalle</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Fecha</th>
                <th>Total Venta</th>
                <th>Método de Pago</th>
                <th>Nombre del Producto</th>
                <th>Nombre del Usuario</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Establecer conexión con la base de datos
                $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");
                if ($conexion->connect_error) {
                    die("Error al conectar con la base de datos: " . $conexion->connect_error);
                }

                // Consultar la vista
                $sql = "SELECT * FROM vista_detalle_venta";
                $resultado = $conexion->query($sql);

                if ($resultado->num_rows > 0) {
                    // Imprimir los registros en la tabla
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $fila['id_detalle'] . "</td>";
                        echo "<td>" . $fila['cantidad'] . "</td>";
                        echo "<td>" . $fila['precio_unitario'] . "</td>";
                        echo "<td>" . $fila['fecha'] . "</td>";
                        echo "<td>" . $fila['total_venta'] . "</td>";
                        echo "<td>" . $fila['metodo_pago'] . "</td>";
                        echo "<td>" . $fila['nombre_producto'] . "</td>";
                        echo "<td>" . $fila['nombre_usuario'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay registros en la vista.</td></tr>";
                }

                // Cerrar la conexión
                $conexion->close();
            ?>
        </tbody>
    </table>

</div>

</body>
</html>