<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Mis Compras</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FFD6E9; 
            font-family: Arial, sans-serif;
            color: #FF6BBD; 
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
            color: #FF6BBD; 
        }

        .info {
            margin-bottom: 20px;
        }

        .info label {
            font-weight: bold;
        }

        .info p {
            margin: 5px 0;
            color: #666; /* Color de texto gris */
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

        .descargar-pdf {
            text-align : right;
        }

        .venta {
            background-color: #FFE6F0; /* Fondo rosa claro */
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .venta p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <a href="perfil.php" class="btn btn-regresar">Regresar</a>
    <div class="container">
        <h1>Mis Compras</h1>
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

        // Obtener el ID del usuario de la sesión
        $id_usuario = $_SESSION['user_id'];

      
        $sql = "SELECT v.*, dv.*, v.nombre_producto, v.total_venta 
                FROM ventas v 
                INNER JOIN detalle_Venta dv ON v.ID_venta = dv.ID_venta 
                WHERE dv.id_cliente = '$id_usuario'";

        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo '<div class="venta">';
                echo "<p>ID de venta: " . $row['ID_venta'] . "</p>";
                echo "<p>Fecha: " . $row['fecha'] . "</p>";
                echo "<p>Producto: " . $row['nombre_producto'] . "</p>";
                echo "<p>Cantidad: " . $row['cantidad'] . "</p>";   
                echo "<p>Total de la venta: $" . $row['total_venta'] . "</p>"; 
                echo "<p>Hora: " . $row['hora'] . "</p>";
                echo "<p>Usuario: " . $row['usuario'] . "</p>";
                 // Formulario para descargar HTML
                echo '<form method="post" action="descargar_venta.php">';
                echo '<input type="hidden" name="ID_venta" value="' . $row['ID_venta'] . '">';
                echo '<input type="hidden" name="fecha" value="' . $row['fecha'] . '">';
                echo '<input type="hidden" name="nombre_producto" value="' . $row['nombre_producto'] . '">';
                echo '<input type="hidden" name="cantidad" value="' . $row['cantidad'] . '">';
                echo '<input type="hidden" name="total_venta" value="' . $row['total_venta'] . '">';
                echo '<input type="hidden" name="hora" value="' . $row['hora'] . '">';
                echo '<input type="hidden" name="usuario" value="' . $row['usuario'] . '">';
                echo '<button type="submit" class="descargar-html">Descargar nota</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "<p>No se encontraron ventas para este usuario.</p>";
        }

        // Cerrar la conexión a la base de datos
        $conexion->close();
        ?>
    </div>
</body>
</html>
