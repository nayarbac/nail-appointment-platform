<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Citas por Fecha</title>
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

        h1 {
            color: #ff69b4; /* Rosa suave */
        }

        form {
            margin-top: 20px;
            text-align: center;
        }

        label {
            margin-right: 10px;
            color: #ff69b4; /* Rosa suave */
        }

        input[type="date"] {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ff69b4; /* Rosa suave */
        }

        button[type="submit"] {
            background-color: #ff69b4; /* Rosa suave */
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #ff1493; /* Rosa más intenso */
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <h1>Listar Citas por Fecha</h1>
    <form method="GET" action="listar_citas.php">
        <label for="fecha">Seleccione la fecha:</label>
        <input type="date" id="fecha" name="fecha" required>
        <button type="submit">Buscar</button>
    </form>

    <?php
    // Verificar si se ha enviado la fecha desde el formulario
    if (isset($_GET['fecha'])) {
        // Conexión a la base de datos
        $mysqli = new mysqli("localhost", "root", "Informatica100*", "estetica");

        // Verificar la conexión
        if ($mysqli->connect_errno) {
            echo "Error al conectar a la base de datos: " . $mysqli->connect_error;
            exit();
        }

        // Preparar la fecha para la consulta
        $fecha = $_GET['fecha'];

        // Ejecutar el procedimiento almacenado
        $result = $mysqli->query("CALL ListarCitasPorFecha('$fecha')");

        // Verificar si se obtuvieron resultados
        if ($result->num_rows > 0) {
            echo "<h2>Citas programadas para el $fecha:</h2>";
            echo "<ul>";
            // Mostrar los resultados
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['nombre_servicio']} - {$row['nombre_estilo']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No se encontraron citas para la fecha especificada.</p>";
        }

        // Cerrar la conexión
        $mysqli->close();
    }
    ?>
</body>
</html>
