<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Carrito con Nombres</title>
    <style>
        body {
            background-color: #fdd; /* Fondo rosa */
            padding-top: 20px;
            font-family: Arial, sans-serif; /* Familia de fuentes */
        }
        h2 {
            margin-bottom: 20px;
            color: #c74e88; /* Letras rosadas */
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff; /* Fondo blanco */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #c74e88; /* Rosa fuerte */
            color: #fff; /* Letras blancas */
        }
        tr:nth-child(even) {
            background-color: #fce8e8; /* Rosa pálido alternado */
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

<h2>Detalle de Carrito con Nombres</h2>

<table>
    <tr>
        <th>ID Detalle</th>
        <th>ID Carrito</th>
        <th>ID Cliente</th>
        <th>Nombre Cliente</th>
        <th>ID Producto</th>
        <th>Nombre Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Total</th>
    </tr>
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

    // Consulta SQL para obtener los datos de la vista
    $sql = "SELECT * FROM vista_detalle_carrito_con_nombres";
    $result = $conn->query($sql);

    // Mostrar los datos en la tabla HTML
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_detalle"] . "</td>";
            echo "<td>" . $row["id_carrito"] . "</td>";
            echo "<td>" . $row["id_cliente"] . "</td>";
            echo "<td>" . $row["nombre_cliente"] . "</td>";
            echo "<td>" . $row["id_producto"] . "</td>";
            echo "<td>" . $row["nombre_producto"] . "</td>";
            echo "<td>" . $row["cantidad"] . "</td>";
            echo "<td>" . $row["precio_unitario"] . "</td>";
            echo "<td>" . $row["total"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>0 resultados</td></tr>";
    }
    $conn->close();
    ?>
</table>

</body>
</html>
