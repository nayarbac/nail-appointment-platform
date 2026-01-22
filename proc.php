<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular Total Gastado por Cliente</title>
    <style>
        /* Estilos CSS */
    </style>
</head>
<body>
    <h2>Calcular Total Gastado por Cliente</h2>
    <form id="calcTotalForm">
        <label for="cliente_id">Selecciona el Cliente:</label>
        <select name="cliente_id" id="cliente_id">
            <?php
            // Establecer la conexión con la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "Informatica100*";
            $database = "estetica";

            $conn = new mysqli($servername, $username, $password, $database);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            // Obtener los IDs y nombres de cliente desde la base de datos
            $sql_clientes = "SELECT ID, nombre FROM clientes";
            $result_clientes = $conn->query($sql_clientes);
            if ($result_clientes->num_rows > 0) {
                while($row_cliente = $result_clientes->fetch_assoc()) {
                    echo "<option value='" . $row_cliente["ID"] . "'>" . $row_cliente["nombre"] . "</option>";
                }
            }

            // Cerrar la conexión
            $conn->close();
            ?>
        </select>
        <button type="button" onclick="calcularTotal()">Calcular</button>
    </form>

    <div id="resultado"></div>

    <script>
        function calcularTotal() {
            var clienteId = document.getElementById("cliente_id").value;

            // Realizar una solicitud AJAX a PHP para calcular el total gastado
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("resultado").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "mostrar_total_gastado.php?cliente_id=" + clienteId, true);
            xhttp.send();
        }
    </script>

    <?php
    // mostrar_total_gastado.php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Establecer la conexión con la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "Informatica100*";
        $database = "estetica";

        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Obtener el cliente_id del formulario
        $cliente_id = $_GET["cliente_id"];

        // Ejecutar el procedimiento almacenado para calcular el total gastado
        $sql = "CALL CalcularTotalGastado($cliente_id)";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h3>Total Gastado por Cliente:</h3>";
            echo "<p>ID del Cliente: " . $cliente_id . "</p>";
            echo "<p>Total Gastado: $" . number_format($row["total_gastado"], 2) . "</p>";
        } else {
            echo "<p>No se encontraron datos para el cliente seleccionado.</p>";
        }

        // Cerrar la conexión
        $conn->close();
    }
    ?>
</body>
</html>
