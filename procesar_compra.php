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
    $sql_cliente = "SELECT ID FROM clientes WHERE correo = '$correo_usuario'";
    $resultado_cliente = $conexion->query($sql_cliente);
    if ($resultado_cliente->num_rows > 0) {
        $cliente = $resultado_cliente->fetch_assoc();
        $id_cliente = $cliente['ID'];
        
        // Obtener el nombre del cliente
        $sql_nombre_cliente = "SELECT nombre FROM clientes WHERE ID = $id_cliente";
        $resultado_nombre_cliente = $conexion->query($sql_nombre_cliente);
        if ($resultado_nombre_cliente->num_rows > 0) {
            $nombre_cliente = $resultado_nombre_cliente->fetch_assoc()['nombre'];
        } else {
            echo "Error: No se encontró el nombre del cliente.";
            exit();
        }
    } else {
        echo "Error: No se encontró al cliente en la base de datos.";
        exit();
    }

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

                // Insertar la venta en la tabla "ventas"
                $sql_insertar_venta = "INSERT INTO ventas (fecha, total_venta, metodo_pago, nombre_producto) VALUES (NOW(), $total_venta, '$metodo_pago', '$nombre_producto')";
                if ($conexion->query($sql_insertar_venta) === TRUE) {
                    $id_venta = $conexion->insert_id; // Obtiene el ID de la venta recién insertada

                    // Insertar el detalle de venta en la tabla "detalle_venta"
                    $sql_insertar_detalle = "INSERT INTO detalle_venta (id_venta, cantidad, id_cliente, precio_unitario, hora, usuario) VALUES ($id_venta, $cantidad_comprada, $id_cliente, $precio_producto, NOW(), '$nombre_cliente')";

                    if ($conexion->query($sql_insertar_detalle) === TRUE) {
                        echo "<script>alert('Compra hecha con éxito');</script>";
echo "<script>window.location.href = 'tienda.php';</script>"; // Redirige a tienda.php

                    } else {
                        echo "<script>alert('Error al registrar el detalle de la venta: " . $conexion->error . "');</script>";
                    }
                } else {
                    echo "<script>alert('Error al registrar la venta: " . $conexion->error . "');</script>";
                }
            } else {
                echo "<script>alert('No se encontró el producto.');</script>";
            }
        } else {
            echo "<script>alert('Error al actualizar el stock: " . $conexion->error . "');</script>";
        }
    } else {
        // Mostrar alerta de error de stock insuficiente
        echo "<script>alert('No hay suficiente cantidad de stock disponible.');</script>";
    }
} else {
    echo "<script>alert('Error: Datos incompletos.');</script>";
}

$conexion->close();
?>

