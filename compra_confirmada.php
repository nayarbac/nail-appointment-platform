<?php
session_start();

// Verifica si se ha confirmado la compra
if(isset($_SESSION['carritos'][$_SESSION['user_id']]) && count($_SESSION['carritos'][$_SESSION['user_id']]) > 0) {
    // Crear el contenido del comprobante de compra en HTML
    $html = '<!DOCTYPE html>';
    $html .= '<html lang="es">';
    $html .= '<head>';
    $html .= '<meta charset="UTF-8">';
    $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>Comprobante de Compra</title>';
    $html .= '</head>';
    $html .= '<body>';
    $html .= '<h1>Detalles de tu compra:</h1>';
    $html .= '<p><strong>Usuario:</strong> ' . $_SESSION['nombre_usuario'] . '</p>';
    $html .= '<h2>Productos:</h2>';
    $html .= '<ul>';

    // Calcular el total de la compra
    $totalCompra = 0;

    foreach($_SESSION['carritos'][$_SESSION['user_id']] as $producto) {
        $nombreProducto = $producto['nombre'];
        $precioUnitario = $producto['precio'];
        $cantidad = $producto['cantidad'];
        $totalProducto = $precioUnitario * $cantidad;
        $totalCompra += $totalProducto;

        $html .= '<li><strong>Nombre:</strong> ' . $nombreProducto . ', <strong>Precio Unitario:</strong> $' . $precioUnitario . ', <strong>Cantidad:</strong> ' . $cantidad . ', <strong>Total:</strong> $' . $totalProducto . '</li>';
    }

    $html .= '</ul>';
    $html .= '<p><strong>Total de la compra:</strong> $' . $totalCompra . '</p>';
    $html .= '</body>';
    $html .= '</html>';

    // Generar el nombre del archivo
    $filename = 'comprobante_compra_' . date('Y-m-d_H-i-s') . '.html';

    // Guardar el archivo
    file_put_contents($filename, $html);

    // Limpiar el carrito después de confirmar la compra
    unset($_SESSION['carritos'][$_SESSION['user_id']]);

    // Mostrar alerta de compra confirmada
    echo '<script>alert("¡Compra confirmada! Carrito comprado exitosamente.");</script>';
    // Redireccionar al usuario a la página del carrito
    echo '<script>window.location.href = "carrito.php";</script>';
    exit();
} else {
    // Redireccionar a la página del carrito si no se ha confirmado la compra
    header('Location: carrito.php');
    exit();
}
?>
