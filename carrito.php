<?php
session_start();


function eliminarProductoDelCarrito($idProducto, $userID) {
    if(isset($_SESSION['carritos'][$userID])) {
        foreach($_SESSION['carritos'][$userID] as $key => $producto) {
            if($producto['id'] == $idProducto) {
                
                unset($_SESSION['carritos'][$userID][$key]);
               
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
function confirmarCompra($userID) {
    // Verificar si el carrito está vacío
    if(isset($_SESSION['carritos'][$userID]) && count($_SESSION['carritos'][$userID]) > 0) {
        // Realizar la conexión a la base de datos
        $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");
        if ($conexion->connect_error) {
            die("Error al conectar con la base de datos: " . $conexion->connect_error);
        }

      
        $conexion->begin_transaction();

       
        $estado = 'comprado';
        $fechaCreacion = date('Y-m-d H:i:s');
        $totalCarrito = 0;
        $metodoPago = $_POST['metodo_pago'];
        $sqlCarrito = "INSERT INTO carrito (estado, fecha_creacion, total_carrito, metodo_pago) VALUES ('$estado', '$fechaCreacion', $totalCarrito, '$metodoPago')";

        // Ejecutar la consulta para insertar el carrito
        if ($conexion->query($sqlCarrito) === TRUE) {
            // Obtenemos el ID del carrito recién insertado
            $idCarrito = $conexion->insert_id;

           
            foreach($_SESSION['carritos'][$userID] as $producto) {
                $idProducto = $producto['id'];
                $cantidad = $producto['cantidad'];
                $precioUnitario = $producto['precio'];
                $totalProducto = $precioUnitario * $cantidad;
                $sqlDetalle = "INSERT INTO detalle_carrito (id_carrito, id_cliente, id_producto, cantidad, precio_unitario, total) VALUES ($idCarrito, $userID, $idProducto, $cantidad, $precioUnitario, $totalProducto)";
                $conexion->query($sqlDetalle);
                // Actualizar el total del carrito
                $totalCarrito += $totalProducto;
            }

            // Actualizar el total del carrito en la tabla carrito
            $sqlUpdateCarrito = "UPDATE carrito SET total_carrito = $totalCarrito WHERE id_carrito = $idCarrito";
            $conexion->query($sqlUpdateCarrito);

            // Confirmar la transacción
            $conexion->commit();

           
            unset($_SESSION['carritos'][$userID]);

           
            $conexion->close();

            echo '<script>alert("¡Compra confirmada! Carrito comprado exitosamente.");</script>';
            echo '<script>window.location.href = "carrito.php";</script>';
            exit(); 
        } else {
            $conexion->rollback();
            echo "Error al registrar la compra: " . $conexion->error;
        }

            
            header('Location: compra_confirmada.php');
            exit();
        } else {
            
            $conexion->rollback();
            echo "Error al registrar la compra: " . $conexion->error;
        }
    }




if(isset($_POST['eliminar_producto']) && isset($_POST['id_producto'])) {
    $idProductoAEliminar = $_POST['id_producto'];
    $userID = $_SESSION['user_id'];
  
    if(eliminarProductoDelCarrito($idProductoAEliminar, $userID)) {
      
        header('Location: carrito.php');
        exit();
    } else {
        
        header('Location: carrito.php?error=1');
        exit();
    }
}


if(isset($_POST['confirmar_compra'])) {
  
    $userID = $_SESSION['user_id'];
    confirmarCompra($userID);
}


$html = '';


$userID = $_SESSION['user_id'];
if(isset($_SESSION['carritos'][$userID]) && count($_SESSION['carritos'][$userID]) > 0) {
    // Inicializar el total del carrito
    $totalCarrito = 0;
    
    foreach($_SESSION['carritos'][$userID] as $producto) {
        $html .= '<div class="producto">';
        $html .= '<p>Nombre: ' . $producto['nombre'] . '</p>';
        $html .= '<p>Precio: $' . $producto['precio'] . '</p>';
        $html .= '<p>Cantidad: ' . $producto['cantidad'] . '</p>';
      
        $estado = isset($producto['estado']) ? $producto['estado'] : 'pendiente'; // Por defecto, el estado es "pendiente"
        $html .= '<p>Estado: ' . $estado . '</p>';
        // Calcular el total de cada producto
        $totalProducto = $producto['precio'] * $producto['cantidad'];
        $html .= '<p>Total del producto: $' . number_format($totalProducto, 2) . '</p>';
       
        $html .= '<form action="" method="post">';
        $html .= '<input type="hidden" name="id_producto" value="' . $producto['id'] . '">';
        $html .= '<button type="submit" name="eliminar_producto" class="btn btn-danger">Eliminar</button>';
        $html .= '</form>';
        $html .= '</div>';
        $html .= '<hr>';
        
        $totalCarrito += $totalProducto;
    }
   
    $html .= '<p>Total del carrito: $' . number_format($totalCarrito, 2) . '</p>';
    
    $html .= '<form action="" method="post">';
    $html .= '<label for="metodo_pago">Seleccione Método de Pago:</label>';
    $html .= '<select name="metodo_pago" id="metodo_pago">';
    $html .= '<option value="oxxo">Pago en OXXO</option>';
    $html .= '<option value="tarjeta_credito">Tarjeta de Crédito</option>';
    $html .= '<option value="tarjeta_debito">Tarjeta de Débito</option>';
    $html .= '</select>';
    $html .= '<br>';
    $html .= '<button type="submit" name="confirmar_compra" class="btn btn-primary">Confirmar Compra</button>';
    $html .= '</form>';
} else {
    
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
        .btn-regresar {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #c74e88;
            border-color: #c74e88;
        }
        .btn-regresar:hover {
            background-color: #a04174;
            border-color: #a04174;
        }
    </style>
</head>
<body>
    
<a href="tienda.php" class="btn btn-regresar text-white">Regresar</a>
    <div class="container">
        <h1> Mi carrito de Compras</h1>
        <?php echo $html; ?>
    </div>
</body>
</html>
