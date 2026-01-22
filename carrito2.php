<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correo'])) {
    header("Location: login.html");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

// Obtener el ID del cliente
$correo = $_SESSION['correo'];
$sql = "SELECT ID FROM clientes WHERE correo = '$correo'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    $id_cliente = $row['ID'];
} else {
    echo "<p>No se encontró el ID del usuario.</p>";
    exit(); // Finalizar el script si no se encuentra el ID del usuario
}

// Obtener el carrito del cliente
$sql_carrito = "SELECT * FROM detalle_carrito WHERE id_cliente = $id_cliente";
$resultado_carrito = $conexion->query($sql_carrito);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <!-- Agrega aquí tus enlaces a estilos CSS -->
</head>
<body>
    <h1>Carrito de Compras</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php
                // Mostrar el carrito del cliente
                if ($resultado_carrito->num_rows > 0) {
                    while ($row_carrito = $resultado_carrito->fetch_assoc()) {
                        // Mostrar la información del carrito
                        echo '<div class="info">';
                        echo '<label>ID del carrito:</label> <p>' . $row_carrito['id_carrito'] . '</p>';
                        echo '<label>Estado:</label> <p>' . $row_carrito['estado'] . '</p>';
                        echo '<label>Fecha de creación:</label> <p>' . $row_carrito['fecha_creacion'] . '</p>';
                        echo '<label>Total del carrito:</label> <p>' . $row_carrito['total_carrito'] . '</p>';
                        echo '<label>Método de pago:</label> <p>' . $row_carrito['metodo_pago'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No se encontraron datos del carrito.</p>";
                }
                ?>
            </div>
            <!-- Agrega aquí tu contenido adicional -->
        </div>
    </div>

    <!-- Agrega aquí tus scripts JavaScript si es necesario -->

    <!-- Agrega aquí tus enlaces a scripts JavaScript -->
</body>
</html>
