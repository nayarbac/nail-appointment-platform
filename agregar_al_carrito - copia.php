<?php
session_start();

if(isset($_GET['id']) && isset($_GET['nombre']) && isset($_GET['precio'])) {
    // Obtener los datos del producto
    $id = $_GET['id'];
    $nombre = $_GET['nombre'];
    $precio = $_GET['precio'];

    // Verificar si el producto existe en la base de datos y obtener su stock
    $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

    if ($conexion->connect_error) {
        die("Error al conectar con la base de datos: " . $conexion->connect_error);
    }

    $sql = "SELECT stock FROM productos WHERE id_producto = $id";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $stock_disponible = $row['stock'];

        // Mostrar un pequeño formulario emergente para ingresar la cantidad
        echo '<script>';
        echo 'var cantidad = prompt("Ingrese la cantidad de productos que desea agregar al carrito (Stock disponible: ' . $stock_disponible . ')");';
        echo 'if(cantidad !== null && !isNaN(cantidad) && parseInt(cantidad) > 0 && parseInt(cantidad) <= ' . $stock_disponible . ') {';
        echo 'var estado = "pendiente";'; // Agregar estado "pendiente"
        echo 'window.location.href = "agregar_al_carrito_confirmacion.php?id=' . $id . '&nombre=' . $nombre . '&precio=' . $precio . '&cantidad=" + cantidad + "&estado=" + estado;'; // Pasar el estado como parámetro
        echo '} else {';
        echo 'alert("La cantidad ingresada no es válida.");';
        echo '}';
        echo '</script>';
    } else {
        echo 'No se encontró el producto en la base de datos.';
    }

    $conexion->close();
} else {
    // Si no se reciben los datos del producto, redireccionar al index
    header('Location: index.php');
}
?>
