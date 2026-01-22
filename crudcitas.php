<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualización de Citas</title>
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
        h1 {
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
    <a href="cruddetalleC.php" class="btn btn-detalle text-white">Detalle de Cita</a>
    <div class="container">
        <h1>Visualización de Citas</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Cita</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Nombre del Servicio</th>
                    <th>Nombre del Estilo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

                if ($conexion->connect_error) {
                    die("Error al conectar con la base de datos: " . $conexion->connect_error);
                }

                $sql = "SELECT * FROM citas";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id_cita"] . "</td>";
                        echo "<td>" . $row["fecha"] . "</td>";
                        echo "<td>" . $row["hora"] . "</td>";
                        echo "<td>" . $row["nombre_servicio"] . "</td>";
                        echo "<td>" . $row["nombre_estilo"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay citas disponibles</td></tr>";
                }

                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
