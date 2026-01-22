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

if (isset($_POST['id_producto'], $_POST['nombre_producto'], $_POST['cantidad'], $_POST['metodo_pago'], $_POST['stock'])) {
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $cantidad_comprada = $_POST['cantidad'];
    $metodo_pago = $_POST['metodo_pago'];
    $stock = $_POST['stock'];
    
    $correo_usuario = $_SESSION['correo'];
    
    // Obtener el ID del cliente
    $sql_cliente = "SELECT ID, nombre FROM clientes WHERE correo = '$correo_usuario'";
    $resultado_cliente = $conexion->query($sql_cliente);
    if ($resultado_cliente->num_rows > 0) {
        $cliente = $resultado_cliente->fetch_assoc();
        $id_cliente = $cliente['ID'];
        $nombre_cliente = $cliente['nombre'];

        // Crear el carrito para este usuario si no existe
        if (!isset($_SESSION['carritos'][$id_cliente])) {
            $_SESSION['carritos'][$id_cliente] = array();
        }
        
        // Obtener el carrito del usuario actual
        $carrito_usuario = &$_SESSION['carritos'][$id_cliente];

        // Verificar si hay suficiente stock para la venta
        if ($stock >= $cantidad_comprada) {
            // Calcular el nuevo stock después de la venta
            $nuevo_stock = $stock - $cantidad_comprada;

            // Actualizar el stock en la base de datos
            $sql_actualizar_stock = "UPDATE productos SET stock = $nuevo_stock WHERE id_producto = $id_producto";
            if ($conexion->query($sql_actualizar_stock) === TRUE) {
                // Calcular el total de la venta
                $sql_producto = "SELECT precio FROM productos WHERE id_producto = $id_producto";
                $resultado_producto = $conexion->query($sql_producto);

                if ($resultado_producto->num_rows > 0) {
                    $producto = $resultado_producto->fetch_assoc();
                    $precio_producto = $producto['precio'];
                    $total_venta = $precio_producto * $cantidad_comprada;

                    // Agregar la compra al carrito del usuario
                    $carrito_usuario[] = array(
                        'id_producto' => $id_producto,
                        'nombre_producto' => $nombre_producto,
                        'cantidad' => $cantidad_comprada,
                        'metodo_pago' => $metodo_pago,
                        'total_venta' => $total_venta
                    );

                    // Redirigir a la página de compra exitosa con un parámetro indicando éxito
                    header('Location: detalle_compra.php?compra_exitosa=1');
                    exit();
                } else {
                    echo "No se encontró el producto.";
                }
            } else {
                echo "Error al actualizar el stock: " . $conexion->error;
            }
        } else {
            echo "No hay suficiente stock disponible para realizar la venta.";
        }
    } else {
        echo "Error: No se encontró al cliente en la base de datos.";
    }
} else {
    echo "Error: Datos incompletos.";
}

$conexion->close();
?>
