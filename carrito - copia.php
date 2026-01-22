<?php
session_start();

// Función para eliminar un producto del carrito
function eliminarProductoDelCarrito($idProducto) {
    if(isset($_SESSION['carritos'][$_SESSION['user_id']])) {
        foreach($_SESSION['carritos'][$_SESSION['user_id']] as $key => $producto) {
            if($producto['id'] == $idProducto) {
                // Eliminar el producto del carrito
                unset($_SESSION['carritos'][$_SESSION['user_id']][$key]);
                // Restaurar la cantidad al stock en la base de datos
                $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");
                if ($conexion->connect_error) {
                    die("Error al conectar con la base de datos: " . $conexion->connect_error);
                }
                $cantidadARestituir = $producto['cantidad'];
                $sql = "UPDATE productos SET stock = stock + $cantidadARestituir WHERE id_producto = $idProducto";
                $conexion->query($sql);
                $conexion->close();
                return true;
            }
        }
    }
    return false;
}

// Función para confirmar la compra y registrarla en la base de datos
function confirmarCompra() {
    // Verificar si el carrito está vacío
    if(isset($_SESSION['carritos'][$_SESSION['user_id']]) && count($_SESSION['carritos'][$_SESSION['user_id']]) > 0) {
        // Calcular el total del carrito
        $totalCarrito = 0;
        foreach($_SESSION['carritos'][$_SESSION['user_id']] as $producto) {
            $totalProducto = $producto['precio'] * $producto['cantidad'];
            $totalCarrito += $totalProducto;
        }

        // Realizar la conexión a la base de datos
        $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");
        if ($conexion->connect_error) {
            die("Error al conectar con la base de datos: " . $conexion->connect_error);
        }

        // Preparar la consulta para insertar en la tabla de carrito
        $estado = 'comprado';
        $fechaCreacion = date('Y-m-d H:i:s');
        $sql = "INSERT INTO carrito (estado, fecha_creacion, total_carrito) VALUES ('$estado', '$fechaCreacion', $totalCarrito)";

        // Ejecutar la consulta
        if ($conexion->query($sql) === TRUE) {
            // Obtenemos el ID del carrito recién insertado
            $idCarrito = $conexion->insert_id;

            // Insertar los productos del carrito en la tabla de productos_carrito
            foreach($_SESSION['carritos'][$_SESSION['user_id']] as $producto) {
                $idProducto = $producto['id'];
                $cantidad = $producto['cantidad'];
                $sqlProductoCarrito = "INSERT INTO productos_carrito (id_carrito, id_producto, cantidad) VALUES ($idCarrito, $idProducto, $cantidad)";
                $conexion->query($sqlProductoCarrito);
            }

            // Limpiar el carrito después de confirmar la compra
            unset($_SESSION['carritos'][$_SESSION['user_id']]);

            // Cerrar la conexión
            $conexion->close();

            // Redireccionar a una página de confirmación o mostrar un mensaje
            header('Location: compra_confirmada.php');
            exit();
        } else {
            echo "Error al registrar la compra: " . $conexion->error;
        }
    }
}

// Verificar si se recibió una solicitud para eliminar un producto del carrito
if(isset($_POST['eliminar_producto']) && isset($_POST['id_producto'])) {
    $idProductoAEliminar = $_POST['id_producto'];
    // Intentar eliminar el producto del carrito y restaurar el stock
    if(eliminarProductoDelCarrito($idProductoAEliminar)) {
        // Redireccionar de vuelta al carrito
        header('Location: carrito.php');
        exit();
    } else {
        // Si no se pudo eliminar el producto, redireccionar de vuelta al carrito con un mensaje de error
        header('Location: carrito.php?error=1');
        exit();
    }
}

// Verificar si se recibió una solicitud para confirmar la compra
if(isset($_POST['confirmar_compra'])) {
    // Confirmar la compra
    confirmarCompra();
}

// Variable para almacenar el HTML a imprimir
$html = '';

// Mostrar los productos en el carrito
if(isset($_SESSION['carritos'][$_SESSION['user_id']]) && count($_SESSION['carritos'][$_SESSION['user_id']]) > 0) {
    // Inicializar el total del carrito
    $totalCarrito = 0;
    // Mostrar los productos del carrito del usuario actual
    foreach($_SESSION['carritos'][$_SESSION['user_id']] as $producto) {
        $html .= '<div class="producto">';
        $html .= '<p>Nombre: ' . $producto['nombre'] . '</p>';
        $html .= '<p>Precio: $' . $producto['precio'] . '</p>';
        $html .= '<p>Cantidad: ' . $producto['cantidad'] . '</p>';
        // Verificar si el estado está definido antes de mostrarlo
        $estado = isset($producto['estado']) ? $producto['estado'] : 'pendiente'; // Por defecto, el estado es "pendiente"
        $html .= '<p>Estado: ' . $estado . '</p>';
        // Calcular el total de cada producto
        $totalProducto = $producto['precio'] * $producto['cantidad'];
        $html .= '<p>Total del producto: $' . number_format($totalProducto, 2) . '</p>';
        // Formulario para eliminar el producto del carrito
        $html .= '<form action="" method="post">';
        $html .= '<input type="hidden" name="id_producto" value="' . $producto['id'] . '">';
        $html .= '<button type="submit" name="eliminar_producto" class="btn btn-danger">Eliminar</button>';
        $html .= '</form>';
        $html .= '</div>';
        $html .= '<hr>';
        // Sumar el total de cada producto al total del carrito
        $totalCarrito += $totalProducto;
    }
    // Mostrar el total del carrito
    $html .= '<p>Total del carrito: $' . number_format($totalCarrito, 2) . '</p>';
    // Botón para confirmar la compra
    $html .= '<form action="" method="post">';
    $html .= '<button type="submit" name="confirmar_compra" class="btn btn-primary">Confirmar Compra</button>';
    $html .= '</form>';
} else {
    // Si no hay productos en el carrito del usuario actual, mostrar un mensaje indicando que está vacío
    $html .= '<p>El carrito está vacío.</p>';
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #ff69b4;
        }
        .producto {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .producto p {
            margin: 5px 0;
        }
        .btn {
            padding: 8px 16px;
            background-color: #ff69b4;
            border: none;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
        }
        .btn-danger {
            background-color: #e74c3c;
        }
        .btn-primary {
            background-color: #3498db;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .empty-cart {
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1> Mi carrito de Compras</h1>
        <?php echo $html; ?>
    </div>
</body>
</html>
