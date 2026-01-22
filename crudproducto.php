<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
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
        .form-group {
            margin-bottom: 10px;
        }
        .btn-warning, .btn-danger {
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

        /* Estilo rosado para los botones de edición y eliminación */
        .btn-warning {
            background-color: #ff7aa8; /* Color rosa */
            border-color: #ff7aa8; /* Borde rosa */
        }

        .btn-warning:hover {
            background-color: #ff4d88; /* Color rosa más oscuro al pasar el mouse */
            border-color: #ff4d88; /* Borde rosa más oscuro al pasar el mouse */
        }

        .btn-danger {
            background-color: #ff7aa8; /* Color rosa */
            border-color: #ff7aa8; /* Borde rosa */
        }

        .btn-danger:hover {
            background-color: #ff4d88; /* Color rosa más oscuro al pasar el mouse */
            border-color: #ff4d88; /* Borde rosa más oscuro al pasar el mouse */
        }
    </style>
</head>
<body>
    <a href="privado.html" class="btn-back">Regresar</a>

    <div class="container mt-5">
        <h2>Lista de Productos</h2>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "Informatica100*";
        $dbname = "estetica";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $message = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = $_POST['action'];
            $id_producto = $_POST['id'];

            if ($action == 'update') {
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
                $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
                $precio = isset($_POST['precio']) ? $_POST['precio'] : '';
                $stock = isset($_POST['stock']) ? $_POST['stock'] : '';
                $color = isset($_POST['color']) ? $_POST['color'] : '';
                $imagen = isset($_POST['imagen']) ? $_POST['imagen'] : '';

                $update_query = "UPDATE productos SET nombre = ?, tipo = ?, precio = ?, stock = ?, color = ?, imagen = ? WHERE id_producto = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("ssdiisi", $nombre, $tipo, $precio, $stock, $color, $imagen, $id_producto);

                if ($stmt->execute()) {
                    $message = "Producto actualizado correctamente.";
                } else {
                    $message = "Error al actualizar el producto: " . $stmt->error;
                }

                $stmt->close();
            } elseif ($action == 'delete') {
                $delete_query = "DELETE FROM productos WHERE id_producto = ?";
                $stmt = $conn->prepare($delete_query);
                $stmt->bind_param("i", $id_producto);

                if ($stmt->execute()) {
                    $message = "Producto eliminado correctamente.";
                } else {
                    $message = "Error al eliminar el producto: " . $stmt->error;
                }

                $stmt->close();
            }
        }

        // Obtén la lista de productos
        $query = "SELECT id_producto, nombre, tipo, precio, stock, color, imagen FROM productos";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            echo "<table class='table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Color</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($producto = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$producto['id_producto']}</td>
                        <td>{$producto['nombre']}</td>
                        <td>{$producto['tipo']}</td>
                        <td>{$producto['precio']}</td>
                        <td>{$producto['stock']}</td>
                        <td>{$producto['color']}</td>
                        <td>{$producto['imagen']}</td>
                        <td>
                            <form action='' method='post' class='form-inline'>
                                <input type='hidden' name='id' value='{$producto['id_producto']}'>
                                <input type='hidden' name='action' value='update'>
                                <div class='form-group mr-2'>
                                    <input type='text' name='nombre' value='{$producto['nombre']}' class='form-control' required>
                                </div>
                                <div class='form-group mr-2'>
                                    <input type='text' name='tipo' value='{$producto['tipo']}' class='form-control' required>
                                </div>
                                <div class='form-group mr-2'>
                                    <input type='number' name='precio' value='{$producto['precio']}' class='form-control' required>
                                </div>
                                <div class='form-group mr-2'>
                                    <input type='number' name='stock' value='{$producto['stock']}' class='form-control' required>
                                </div>
                                <div class='form-group mr-2'>
                                    <input type='text' name='color' value='{$producto['color']}' class='form-control' required>
                                </div>
                                <div class='form-group mr-2'>
                                    <input type='text' name='imagen' value='{$producto['imagen']}' class='form-control' required>
                                </div>
                                <button type='submit' class='btn btn-warning'>Editar</button>
                            </form>
                        </td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<tr><td colspan='8'>No se encontraron productos.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <?php echo $message; ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
