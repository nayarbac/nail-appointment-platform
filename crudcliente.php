<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes y Administradores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #fdd;
            padding-top: 20px;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            margin-bottom: 20px;
            color: #c74e88;
        }
        table {
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #c74e88;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-success, .btn-primary, .btn-danger {
            margin-right: 10px;
        }

        /* Estilos para el botón de regresar */
        .btn-back {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #ff7aa8; /* Color rosa */
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #ff4d88; /* Color rosa más oscuro al pasar el mouse */
        }
    </style>
</head>
<body>
    <a href="privado.html" class="btn-back">Regresar</a>

    <div class="container mt-5">
        <h2>Lista de Clientes</h2>
        
        <?php
$servername = "localhost";
$username = "root";
$password = "Informatica100*";
$dbname = "estetica";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function limpiar($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Tu código para agregar un cliente aquí
    } elseif (isset($_POST['edit'])) {
        $id = limpiar($_POST['id']);
        $nombre = limpiar($_POST['nombre']);
        $telefono = limpiar($_POST['telefono']);
        $correo = limpiar($_POST['correo']);
        $domicilio = limpiar($_POST['domicilio']);
        $contrasena = limpiar($_POST['contrasena']);
        $tipo_usuario = limpiar($_POST['tipo_usuario']);
        $sql = "UPDATE clientes SET nombre='$nombre', telefono='$telefono', correo='$correo', domicilio='$domicilio', contrasena='$contrasena', tipo_usuario='$tipo_usuario' WHERE ID=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Cliente actualizado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error al actualizar cliente: " . $conn->error . "</div>";
        }
    } elseif (isset($_POST['deactivate'])) {
        $id = limpiar($_POST['id']);
        $sql = "UPDATE clientes SET estado='inactivo' WHERE ID=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Cliente desactivado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error al desactivar cliente: " . $conn->error . "</div>";
        }
    } elseif (isset($_POST['activate'])) {
        $id = limpiar($_POST['id']);
        $sql = "UPDATE clientes SET estado='activo' WHERE ID=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Cliente activado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error al activar cliente: " . $conn->error . "</div>";
        }
    }
}

$sql = "SELECT ID, nombre, telefono, correo, domicilio, contrasena, tipo_usuario, estado FROM clientes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Domicilio</th>
                    <th>Contraseña</th>
                    <th>Tipo Usuario</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['ID'] . "</td>
                <td>" . $row['nombre'] . "</td>
                <td>" . $row['telefono'] . "</td>
                <td>" . $row['correo'] . "</td>
                <td>" . $row['domicilio'] . "</td>
                <td>" . $row['contrasena'] . "</td>
                <td>" . $row['tipo_usuario'] . "</td>
                <td>" . $row['estado'] . "</td>
                <td>
                    <form action='' method='post'>
                        <input type='hidden' name='id' value='" . $row['ID'] . "'>
                        <input type='text' name='nombre' value='" . $row['nombre'] . "'>
                        <input type='text' name='telefono' value='" . $row['telefono'] . "'>
                        <input type='text' name='correo' value='" . $row['correo'] . "'>
                        <input type='text' name='domicilio' value='" . $row['domicilio'] . "'>
                        <input type='text' name='contrasena' value='" . $row['contrasena'] . "'>
                        <input type='text' name='tipo_usuario' value='" . $row['tipo_usuario'] . "'>
                        <button type='submit' name='edit' class='btn btn-primary'>Editar</button>";
                        if ($row['estado'] == 'activo') {
                            echo "<button type='submit' name='deactivate' class='btn btn-danger'>Desactivar</button>";
                        } else {
                            echo "<button type='submit' name='activate' class='btn btn-success'>Activar</button>";
                        }
        echo "</form>
                </td>
            </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<div class='alert alert-info' role='alert'>No se encontraron clientes.</div>";
}

$conn->close();
?>



    </div>
</body>
</html>