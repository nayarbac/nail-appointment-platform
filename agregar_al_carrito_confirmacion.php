<?php
session_start();

if(isset($_GET['id']) && isset($_GET['nombre']) && isset($_GET['precio']) && isset($_GET['cantidad'])) {
    // Obtener los datos del producto y la cantidad
    $id = $_GET['id'];
    $nombre = $_GET['nombre'];
    $precio = $_GET['precio'];
    $cantidad = $_GET['cantidad'];

    // Crear un nuevo elemento para el carrito
    $producto = array(
        'id' => $id,
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad
    );

    // Verificar si ya existe el carrito en la sesión
    if(isset($_SESSION['carritos'][$_SESSION['user_id']])) {
        // Verificar si el producto ya está en el carrito
        $index = -1;
        foreach($_SESSION['carritos'][$_SESSION['user_id']] as $key => $item) {
            if($item['id'] == $id) {
                $index = $key;
                break;
            }
        }

        if($index != -1) {
            // Si el producto ya está en el carrito, actualizar la cantidad
            $_SESSION['carritos'][$_SESSION['user_id']][$index]['cantidad'] += $cantidad;
        } else {
            // Si el producto no está en el carrito, agregarlo
            $_SESSION['carritos'][$_SESSION['user_id']][] = $producto;
        }
    } else {
        // Si no existe el carrito en la sesión, crear uno nuevo
        $_SESSION['carritos'][$_SESSION['user_id']] = array($producto);
    }

    // Actualizar el stock del producto en la base de datos
    $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

    if ($conexion->connect_error) {
        die("Error al conectar con la base de datos: " . $conexion->connect_error);
    }

    // Actualizar el stock restando la cantidad agregada al carrito
    $sql = "UPDATE productos SET stock = stock - $cantidad WHERE id_producto = $id";
    $conexion->query($sql);
    $conexion->close();

   
    header('Location: carrito.php');
} else {
    
    header('Location: index.php');
}
?>