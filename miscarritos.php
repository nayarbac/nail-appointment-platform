<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['correo'])) {
    header("Location: login.html");
    exit();
}

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");
if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

// Obtener el correo del usuario de la sesión
$correo_usuario = $_SESSION['correo'];

// Consultar el ID del usuario usando su correo electrónico
$sql = "SELECT ID FROM clientes WHERE correo = '$correo_usuario'";
$resultado = $conexion->query($sql);

// Verificar si se encontró el usuario
if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    $id_usuario = $row['ID'];

    // Consultar los carritos del usuario actual
    $sql_carritos = "SELECT * FROM vista_detalle_carrito_con_nombres WHERE id_cliente = '$id_usuario'";
    $resultado_carritos = $conexion->query($sql_carritos);

    // Mostrar los carritos del usuario actual
    if ($resultado_carritos->num_rows > 0) {
        echo '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Mis Carritos</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    background-color: #FFD6E9; /* Fondo rosado */
                    font-family: Arial, sans-serif;
                    color: #FF6BBD; /* Color de texto rosa */
                }   
                
                .container {
                    max-width: 800px;
                    margin: 50px auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    position: relative;
                }
        
                h1 {
                    text-align: center;
                    margin-bottom: 30px;
                    color: #FF6BBD; /* Color de texto rosa */
                }
        
                .btn-regresar {
                    background-color: #c74e88;
                    border-color: #c74e88;
                    color: #fff;
                    padding: 8px 16px;
                    border-radius: 4px;
                    cursor: pointer;
                }
        
                .btn-regresar:hover {
                    background-color: #a04174;
                    border-color: #a04174;
                }
        
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
        
                th, td {
                    padding: 8px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                }
            </style>
        </head>
        <body>
            <!-- Encabezado y botón de regreso -->
            <a href="perfil.php" class="btn btn-regresar">Regresar</a>
            <div class="container">
                <h1>Mis Carritos</h1>';
                
        echo '<table>';
        echo '<tr>
                <th>ID Detalle</th>
                <th>ID Carrito</th>
                <th>ID Cliente</th>
                <th>Nombre Cliente</th>
                <th>ID Producto</th>
                <th>Nombre Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Acción</th>
            </tr>';
        while ($row_carrito = $resultado_carritos->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row_carrito["id_detalle"] . '</td>';
            echo '<td>' . $row_carrito["id_carrito"] . '</td>';
            echo '<td>' . $row_carrito["id_cliente"] . '</td>';
            echo '<td>' . $row_carrito["nombre_cliente"] . '</td>';
            echo '<td>' . $row_carrito["id_producto"] . '</td>';
            echo '<td>' . $row_carrito["nombre_producto"] . '</td>';
            echo '<td>' . $row_carrito["cantidad"] . '</td>';
            echo '<td>' . $row_carrito["precio_unitario"] . '</td>';
            echo '<td>' . $row_carrito["total"] . '</td>';
            // Formulario para descargar nota de carrito
            echo '<td><form method="post" action="descargar_carrito.php">
                    <input type="hidden" name="id_detalle" value="' . $row_carrito['id_detalle'] . '">
                    <input type="hidden" name="id_carrito" value="' . $row_carrito['id_carrito'] . '">
                    <input type="hidden" name="id_cliente" value="' . $row_carrito['id_cliente'] . '">
                    <input type="hidden" name="nombre_cliente" value="' . $row_carrito['nombre_cliente'] . '">
                    <input type="hidden" name="id_producto" value="' . $row_carrito['id_producto'] . '">
                    <input type="hidden" name="nombre_producto" value="' . $row_carrito['nombre_producto'] . '">
                    <input type="hidden" name="cantidad" value="' . $row_carrito['cantidad'] . '">
                    <input type="hidden" name="precio_unitario" value="' . $row_carrito['precio_unitario'] . '">
                    <input type="hidden" name="total" value="' . $row_carrito['total'] . '">
                    <button type="submit">Descargar Nota de Carrito</button>
                  </form></td>';
            echo '</tr>';
        }
        echo '</table>';
        
        echo '</div>
        </body>
        </html>';
    } else {
        echo "<p>No se encontraron carritos para este usuario.</p>";
    }
} else {
    echo "<p>Error: No se pudo encontrar el usuario en la base de datos.</p>";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
