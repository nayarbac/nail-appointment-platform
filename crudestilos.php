<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Estilos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            background-color: #fff6f9; /* Fondo rosado claro */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            margin-bottom: 20px;
            color: #c74e88; /* Rosa */
        }
        table {
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #c74e88; /* Rosa */
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-success {
            background-color: #28a745; /* Verde */
            border-color: #28a745; /* Borde verde */
        }
        .btn-primary {
            background-color: #007bff; /* Azul */
            border-color: #007bff; /* Borde azul */
        }
        .btn-danger {
            margin-right: 10px;
            background-color: #dc3545; /* Rojo */
            border-color: #dc3545; /* Borde rojo */
        }
        .btn-success:hover, .btn-primary:hover, .btn-danger:hover {
            opacity: 0.8;
        }
        input[type="text"], input[type="number"] {
            border-color: #c74e88; /* Rosa */
        }
        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #6c757d; /* Gris */
            border-color: #6c757d; /* Borde gris */
            color: white;
        }
        .btn-back:hover {
            background-color: #5a6268; /* Gris más oscuro */
            border-color: #545b62; /* Borde gris más oscuro */
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">
    <a href="privado.html" class="btn btn-back">Regresar</a> <!-- Reemplaza ENLACE_AQUI con el enlace deseado -->
    <div class="container mt-5">
        <h2>Lista de estilos</h2>
        
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
            if (isset($_POST['edit'])) {
                $id_categoria = limpiar($_POST['id_categoria']);
                $nombre = limpiar($_POST['nombre']);
                $imagen = limpiar($_POST['imagen']);
                $precio = limpiar($_POST['precio']);

                
                if (empty($nombre) || empty($precio)) {
                    echo "<div class='alert alert-danger' role='alert'>El nombre y el precio son requeridos.</div>";
                } else {
                    $sql = "UPDATE estilos SET nombre='$nombre', imagen='$imagen', precio='$precio' WHERE id_categoria=$id_categoria";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success' role='alert'>Estilo actualizado correctamente.</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Error al actualizar estilo: " . $conn->error . "</div>";
                    }
                }
            } elseif (isset($_POST['delete'])) {
                $id_categoria = limpiar($_POST['id_categoria']);
                $sql = "DELETE FROM estilos WHERE id_categoria=$id_categoria";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success' role='alert'>Estilo eliminado correctamente.</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error al eliminar estilo: " . $conn->error . "</div>";
                }
            }
        }

        
        $sql = "SELECT id_categoria, nombre, imagen, precio FROM estilos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Imagen</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id_categoria'] . "</td>
                        <form action='' method='post'>
                            <td><input type='text' name='nombre' value='" . $row['nombre'] . "' style='border-color: #c74e88;' required></td>
                            <td><input type='text' name='imagen' value='" . $row['imagen'] . "' style='border-color: #c74e88;' required></td>
                            <td><input type='number' name='precio' value='" . $row['precio'] . "' style='border-color: #c74e88;' min='0' step='0.01' required></td>
                            <td>
                                <input type='hidden' name='id_categoria' value='" . $row['id_categoria'] . "'>
                                <button type='submit' name='edit' class='btn btn-primary'>Editar</button>
                                <button type='submit' name='delete' class='btn btn-danger'>Eliminar</button>
                            </td>
                        </form>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-info' role='alert'>No se encontraron estilos.</div>";
        }

        
        $conn->close();
        ?>

       
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
