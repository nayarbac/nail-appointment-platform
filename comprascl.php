<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Compras por Cliente</title>
</head>
<body>
    <h2>Calculadora de Compras por Cliente</h2>
    <form id="calcTotalForm">
        <label for="cliente_id">Selecciona el Cliente:</label>
        <select name="cliente_id" id="cliente_id">
            <!-- Aquí se cargarán los nombres de los clientes desde PHP -->
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

            // Obtener los nombres de los clientes desde la base de datos
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
        <button type="button" onclick="calcularTotal()">Calcular Total de Compras</button>
    </form>

    <div id="resultado"></div>

    <script>
        function calcularTotal() {
            var clienteId = document.getElementById("cliente_id").value;

            // Realizar una solicitud AJAX a PHP para calcular el total de compras
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("resultado").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "mostrar_total_compras.php?cliente_id=" + clienteId, true);
            xhttp.send();
        }
    </script>
</body>
</html>
