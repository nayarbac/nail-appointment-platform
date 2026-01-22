<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular Total de Compras</title>
</head>
<body>
    <h1>Calcular Total de Compras por Cliente</h1>
    <form action="calcular_total.php" method="post">
        <label for="cliente">Seleccionar Cliente:</label>
        <select name="cliente" id="cliente">
            <!-- Aquí se cargarán los nombres de los clientes desde la base de datos -->
            <?php
            // Conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "Informatica100*";
            $dbname = "estetica";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Consulta para obtener los nombres de los clientes
            $sql = "SELECT ID, nombre FROM clientes";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Mostrar opciones de clientes en el selector
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["ID"] . "'>" . $row["nombre"] . "</option>";
                }
            } else {
                echo "0 resultados";
            }
            $conn->close();
            ?>
        </select>
        <button type="submit">Calcular Total</button>
    </form>
</body>
</html>

