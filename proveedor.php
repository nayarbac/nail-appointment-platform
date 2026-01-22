<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Proveedores</title>
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
        h2 {
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
        .btn-primary, .btn-danger, .btn-success {
            margin-top: 10px;
        }
        /* Estilos para el botón de regresar */
        .btn-back {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #c74e88;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #a63272;
        }
    </style>
</head>
<body>
    <a href="privado.html" class="btn-back">Regresar</a>

    <div class="container mt-5">
        <h2>CRUD de Proveedores</h2>
        
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
                $nombre = limpiar($_POST['nombre']);
                $telefono = limpiar($_POST['telefono']);
                $correo = limpiar($_POST['correo']);
                $tipo = limpiar($_POST['tipo']);
                $sql = "INSERT INTO proveedor (nombre, telefono, correo, tipo) VALUES ('$nombre', '$telefono', '$correo', '$tipo')";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success' role='alert'>Proveedor agregado correctamente.</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error al agregar proveedor: " . $conn->error . "</div>";
                }
            } elseif (isset($_POST['edit'])) {
                $id_proveedor = limpiar($_POST['id_proveedor']);
                $nombre = limpiar($_POST['nombre']);
                $telefono = limpiar($_POST['telefono']);
                $correo = limpiar($_POST['correo']);
                $tipo = limpiar($_POST['tipo']);
                $sql = "UPDATE proveedor SET nombre='$nombre', telefono='$telefono', correo='$correo', tipo='$tipo' WHERE id_proveedor=$id_proveedor";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success' role='alert'>Proveedor actualizado correctamente.</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error al actualizar proveedor: " . $conn->error . "</div>";
                }
            } elseif (isset($_POST['delete'])) {
                $id_proveedor = limpiar($_POST['id_proveedor']);
                $sql = "DELETE FROM proveedor WHERE id_proveedor=$id_proveedor";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success' role='alert'>Proveedor eliminado correctamente.</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error al eliminar proveedor: " . $conn->error . "</div>";
                }
            }
        }

      
        $sql = "SELECT id_proveedor, nombre, telefono, correo, tipo FROM proveedor";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id_proveedor'] . "</td>
                        <td>" . $row['nombre'] . "</td>
                        <td>" . $row['telefono'] . "</td>
                        <td>" . $row['correo'] . "</td>
                        <td>" . $row['tipo'] . "</td>
                        <td>
                            <form action='' method='post'>
                                <input type='hidden' name='id_proveedor' value='" . $row['id_proveedor'] . "'>
                                <input type='text' name='nombre' value='" . $row['nombre'] . "'>
                                <input type='text' name='telefono' value='" . $row['telefono'] . "'>
                                <input type='text' name='correo' value='" . $row['correo'] . "'>
                                <input type='text' name='tipo' value='" . $row['tipo'] . "'>
                                <button type='submit' name='edit' class='btn btn-primary'>Editar</button>
                                <button type='submit' name='delete' class='btn btn-danger'>Eliminar</button>
                            </form>
                        </td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-info' role='alert'>No se encontraron proveedores.</div>";
        }

     
        $conn->close();
        ?>

        <h3>Agregar Nuevo Proveedor</h3>
        <form action="" method="post">
            <div class="form-group">
                <label for="nombre">Nombre del Proveedor:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo">
            </div>
            <div class="form-group">
                <label for="tipo">Tipo de Proveedor:</label>
                <input type="text" class="form-control" id="tipo" name="tipo">
            </div>
            <button type="submit" name="add" class="btn btn-success">Agregar Proveedor</button>
        </form>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
