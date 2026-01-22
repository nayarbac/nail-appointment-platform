<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Citas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Citas</h1>
    <table>
        <tr>
            <th>ID de Cita</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Nombre del Servicio</th>
            <th>Nombre del Estilo</th>
            <th>Completada</th>
            <th>Acción</th>
        </tr>
        <?php
            // Conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "Informatica100*";
            $database = "estetica";

            // Crear conexión
            $conn = new mysqli($servername, $username, $password, $database);

            // Chequear conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Consulta SQL para obtener las citas
            $sql = "SELECT id_cita, fecha, hora, nombre_servicio, nombre_estilo, completada FROM citas";
            $result = $conn->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Mostrar datos de cada fila
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id_cita"] . "</td>";
                    echo "<td>" . $row["fecha"] . "</td>";
                    echo "<td>" . $row["hora"] . "</td>";
                    echo "<td>" . $row["nombre_servicio"] . "</td>";
                    echo "<td>" . $row["nombre_estilo"] . "</td>";
                    echo "<td>" . ($row["completada"] ? "Sí" : "No") . "</td>";
                    echo "<td>";
                    // Botón para marcar como completada usando JavaScript y AJAX
                    echo "<button onclick='marcarComoCompletada(" . $row["id_cita"] . ")'>Marcar como Completada</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>0 resultados</td></tr>";
            }
            // Cerrar conexión
            $conn->close();
        ?>
    </table>

    <script>
        function marcarComoCompletada(idCita) {
            // Creamos un objeto XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Configuramos la solicitud
            xhr.open("POST", "marcar_completada.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Función de devolución de llamada cuando la solicitud AJAX se completa
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Si la solicitud se realizó con éxito, recargamos la página para ver los cambios
                    location.reload();
                } else {
                    // Si hay un error, mostramos un mensaje de error
                    alert("Error al marcar la cita como completada.");
                }
            };

            // Enviamos la solicitud con el ID de la cita como datos de formulario
            xhr.send("id_cita=" + idCita);
        }
    </script>
</body>
</html>
