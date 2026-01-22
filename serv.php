<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicio más solicitado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fce4ec; /* Fondo rosita */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
            width: 80%;
            max-width: 600px; /* Limitar el ancho para que se vea mejor en pantallas grandes */
        }

        .container:nth-child(2) {
            background-color: #ffebee; /* Fondo rosado claro */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ffcdd2; /* Fondo rosado */
        }

        /* Estilos para el botón de regresar */
        .btn-back {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #ff4081; /* Color rosa */
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #f50057; /* Color rosa más oscuro al pasar el mouse */
        }
    </style>
</head>
<body>

<a href="javascript:history.back()" class="btn-back">Regresar</a>

<div class="container">
    <?php
    // Establecer la conexión con la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "Informatica100*";
    $database = "estetica";

    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    // Ejecutar la función y obtener el resultado
    $sql = "SELECT servicio_mas_solicitado() AS servicio";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar el resultado
        while($row = $result->fetch_assoc()) {
            echo "<p>El servicio más solicitado actualmente es: " . $row["servicio"] . "</p>";
        }
    } else {
        echo "<p>No se encontraron resultados.</p>";
    }

    // Cerrar la conexión
    $conn->close();
    ?>
</div>

<div class="container">
    <h2>Servicios más solicitados</h2>
    <table>
        <tr>
            <th>Servicio</th>
            <th>Cantidad de veces solicitado</th>
        </tr>
        <?php
        // Establecer la conexión con la base de datos
        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("La conexión falló: " . $conn->connect_error);
        }

        // Consulta para obtener los datos de la vista
        $sql = "SELECT nombre_servicio, cantidad_pedidos FROM vista_servicios_pedidos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Mostrar los datos en la tabla
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["nombre_servicio"] . "</td><td>" . $row["cantidad_pedidos"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No se encontraron resultados.</td></tr>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </table>
</div>

</body>
</html>
