<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Perfil</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FFD6E9; /* Fondo rosado */
            font-family: Arial, sans-serif;
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
            color: #FF6BBD; /* Color de texto rosa */
        }

        .info p {
            margin: 5px 0;
            color: #666; /* Color de texto gris */
        }

        .edit-form {
            display: none;
        }

        a {
            color: #FF6BBD; /* Color de texto rosa para enlaces */
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        a:hover {
            color: #E83496; /* Color de texto rosa más oscuro al pasar el ratón */
        }
        .btn-mis-compras,
.btn-mis-citas,
.btn-mis-carritos {
    display: block;
    width: 200px;
    margin: 0 auto;
    margin-top: 20px;
    background-color: #FF6BBD; /* Rosa */
    border-color: #FF6BBD; /* Rosa */
    color: #fff;
    padding: 8px 16px;
    border-radius: 4px;
    text-align: center;
    text-decoration: none;
}

.btn-mis-compras:hover,
.btn-mis-citas:hover,
.btn-mis-carritos:hover {
    background-color: #E83496; /* Rosa más oscuro */
    border-color: #E83496; /* Rosa más oscuro */
}

.btn-regresar {
    position: absolute;
    top: 20px;
    left: 20px;
    background-color: #FF6BBD; /* Rosa */
    border-color: #FF6BBD; /* Rosa */
    color: #fff;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-regresar:hover {
    background-color: #E83496; /* Rosa más oscuro */
    border-color: #E83496; /* Rosa más oscuro */
}

    </style>
</head>
<body>
    <a href="menu.php" class="btn btn-regresar">Regresar</a>
    <div class="container">
        <h1>Perfil del Usuario</h1>
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

        $correo = $_SESSION['correo'];

        $sql = "SELECT * FROM clientes WHERE correo = '$correo'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo '<div class="info">';
                echo '<label>ID de usuario:</label> <p>' . $row['ID'] . '</p>';
                echo '<label>Nombre:</label> <p>' . $row['nombre'] . '</p>';
                echo '<label>Teléfono:</label> <p>' . $row['telefono'] . '</p>';
                echo '<label>Correo electrónico:</label> <p>' . $row['correo'] . '</p>';
                echo '<label>Domicilio:</label> <p>' . $row['domicilio'] . '</p>';
                
                // Formulario de edición oculto
                echo '<div class="edit-form">';
                echo '<form action="actualizar_datos.php" method="POST">';
                echo '<label for="nombre">Nombre:</label>';
                echo '<input type="text" id="nombre" name="nombre" value="' . $row['nombre'] . '">';
                echo '<label for="telefono">Teléfono:</label>';
                echo '<input type="text" id="telefono" name="telefono" value="' . $row['telefono'] . '">';
                echo '<label for="correo">Correo electrónico:</label>';
                echo '<input type="email" id="correo" name="correo" value="' . $row['correo'] . '">';
                echo '<label for="domicilio">Domicilio:</label>';
                echo '<input type="text" id="domicilio" name="domicilio" value="' . $row['domicilio'] . '">';
                echo '<button type="submit">Guardar cambios</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "<p>No se encontraron datos del usuario.</p>";
        }
        ?>
        <a href="miscompras.php?id=<?php echo $_SESSION['ID']; ?>" class="btn btn-mis-compras">Mis compras</a>
<a href="miscitas.php?id=<?php echo $_SESSION['ID']; ?>" class="btn btn-mis-citas">Mis citas</a>
<a href="miscarritos.php?id=<?php echo $_SESSION['ID']; ?>" class="btn btn-mis-carritos">Mis carritos</a>


    </div>

    <script>
        function showEditForm() {
            var editForm = document.querySelector('.edit-form');
            if (editForm.style.display === 'none') {
                editForm.style.display = 'block';
            } else {
                editForm.style.display = 'none';
            }
        }
    </script>
</body>
</html>
