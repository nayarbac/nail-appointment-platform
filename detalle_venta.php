<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header("Location: login.html");
    exit();
}

$correo = $_SESSION['correo'];

$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

// Obtener el ID del cliente actualmente loggeado
$sql_cliente_id = "SELECT ID FROM clientes WHERE correo = '$correo'";
$resultado_cliente_id = $conexion->query($sql_cliente_id);

if ($resultado_cliente_id->num_rows > 0) {
    $fila_cliente_id = $resultado_cliente_id->fetch_assoc();
    $cliente_id = $fila_cliente_id['ID'];

    // Obtener los datos necesarios para la venta (por ejemplo, ID del producto, cantidad, etc.)
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $cantidad_comprada = $_POST['cantidad'];
    $metodo_pago = $_POST['metodo_pago'];

    // Calcular el total de la venta
    $sql_precio_producto = "SELECT precio FROM productos WHERE id_producto = $id_producto";
    $resultado_precio_producto = $conexion->query($sql_precio_producto);

    if ($resultado_precio_producto->num_rows > 0) {
        $fila_precio_producto = $resultado_precio_producto->fetch_assoc();
        $precio_producto = $fila_precio_producto['precio'];
        $cuenta_total = $precio_producto * $cantidad_comprada;

        // Insertar los detalles de la venta en la tabla detalle_venta
        $sql_insertar_detalle_venta = "INSERT INTO detalle_venta (cantidad, producto, cliente_id, cuenta_total) VALUES ($cantidad_comprada, '$nombre_producto', $cliente_id, $cuenta_total)";
        if ($conexion->query($sql_insertar_detalle_venta) === TRUE) {
            // Aquí puedes mostrar un mensaje de éxito o redireccionar a una página de confirmación de compra
            echo "¡La compra se realizó correctamente!";
        } else {
            echo "Error al insertar los detalles de la venta: " . $conexion->error;
        }
    } else {
        echo "No se encontró el precio del producto.";
    }
} else {
    echo "No se encontró el cliente.";
}

$conexion->close();
?>
