<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Mis Citas</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FFD6E9; /* Fondo roado */
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

        .cita {
            background-color: #FFE6F0; /* Fondo rosa claro */
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .cita p {
            margin: 5px 0;
        }

        .btn-mis-compras,
        .btn-mis-citas {
            display: block;
            width: 200px;
            margin: 0 auto;
            margin-top: 20px;
            background-color: #c74e88;
            border-color: #c74e88;
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
        }

        .btn-mis-compras:hover,
        .btn-mis-citas:hover {
            background-color: #a04174;
            border-color: #a04174;
        }
    </style>
</head>
<body>
    <a href="perfil.php" class="btn btn-regresar">Regresar</a>
    <div class="container">
        <h1>Mis Citas</h1>
        <?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['correo'])) {
    header("Location: login.html");
    exit();
}

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['user_id']; // Asumiendo que 'user_id' es el nombre correcto del índice que almacena el ID de usuario en la sesión

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");
if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

// Consultar las citas del usuario actual
$sql = "SELECT * FROM detalle_cita WHERE id_cliente = '$id_usuario'";
$resultado = $conexion->query($sql);

// Mostrar las citas del usuario actual
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        echo '<div class="cita">';
        echo "<p>ID de cita: " . $row['id_cita'] . "</p>";
        echo "<p>Cliente: " . $row['cliente'] . "</p>";
        echo "<p>Nombre del servicio: " . $row['nombre_servicio'] . "</p>";
        echo "<p>Nombre del estilo: " . $row['nombre_estilo'] . "</p>";
        echo "<p>Fecha: " . $row['fecha'] . "</p>";
        echo "<p>Hora: " . $row['hora'] . "</p>";
        echo "<p>Precio total: $" . $row['precio_total'] . "</p>";
        
        // Formulario para descargar HTML de la cita
        echo '<form method="post" action="descargar_cita.php">';
        echo '<input type="hidden" name="id_cita" value="' . $row['id_cita'] . '">';
        echo '<input type="hidden" name="cliente" value="' . $row['cliente'] . '">';
        echo '<input type="hidden" name="nombre_servicio" value="' . $row['nombre_servicio'] . '">';
        echo '<input type="hidden" name="nombre_estilo" value="' . $row['nombre_estilo'] . '">';
        echo '<input type="hidden" name="fecha" value="' . $row['fecha'] . '">';
        echo '<input type="hidden" name="hora" value="' . $row['hora'] . '">';
        echo '<input type="hidden" name="precio_total" value="' . $row['precio_total'] . '">';
        echo '<button type="submit" class="descargar-html">Descargar cita</button>';
        echo '</form>';
        
        echo '</div>';
    }
} else {
    echo "<p>No se encontraron citas para este usuario.</p>";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
    
        <a href="miscompras.php?id=<?php echo $_SESSION['ID']; ?>" class="btn btn-mis-compras">Mis Compras</a>
    </div>
</body>
</html>
