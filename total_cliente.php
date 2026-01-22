<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Gastado por Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Calcular Total Gastado por Cliente</h2>
    <form method="post" action="mostrar_total_gastado.php">
        <label for="cliente_id">Selecciona el ID del Cliente:</label>
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

            // Obtener los IDs de cliente desde la base de datos
            $sql_clientes = "SELECT ID, nombre FROM clientes";
            $result_clientes = $conn->query($sql_clientes);
            if ($result_clientes->num_rows > 0) {
                while($row_cliente = $result_clientes->fetch_assoc()) {
                    echo "<option value='" . $row_cliente["ID"] . "'>" . $row_cliente["nombre"] . " (ID: " . $row_cliente["ID"] . ")</option>";
                }
            }
            ?>
        </select>
        <button type="submit">Calcular</button>
    </form>
</body>
</html>
