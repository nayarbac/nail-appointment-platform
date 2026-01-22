<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Venta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Estilos CSS aquí */
    </style>
</head>
<body>

<!-- Contenido HTML aquí -->

<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header("Location: login.html");
    exit();
}

$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

$correo = $_SESSION['correo'];

$sql = "SELECT * FROM vista_detalle_venta WHERE nombre_usuario = '$correo'";

$resultado = $conexion->query($sql);

echo "<div class='container'>";
echo "<h2>Detalle de Venta</h2>";
echo "<table>";
echo "<thead>";
echo "<tr>";
echo "<th>ID Detalle</th>";
echo "<th>Cantidad</th>";
echo "<th>Precio Unitario</th>";
echo "<th>Fecha</th>";
echo "<th>Total Venta</th>";
echo "<th>Método de Pago</th>";
echo "<th>Nombre del Producto</th>";
echo "<th>Nombre del Usuario</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

if ($resultado->num_rows > 0) {
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
    echo "<tr><td colspan='8'>No hay registros en la vista para el usuario $correo.</td></tr>";
}

// Cerrar la conexión
$conexion->close();

echo "</tbody>";
echo "</table>";
echo "</div>";
?>

</body>
</html>
