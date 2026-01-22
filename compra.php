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

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_producto = $conexion->real_escape_string($_GET['id']);

    $sql_producto = "SELECT * FROM productos WHERE id_producto = $id_producto";
    $resultado_producto = $conexion->query($sql_producto);

    if ($resultado_producto->num_rows > 0) {
        $producto = $resultado_producto->fetch_assoc();

        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Detalle de Producto</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <style>
                body {
                    background-color: #FFC9F4;
                }

                .card {
                    width: 400px;
                    margin: 50px auto;
                    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                    transition: 0.3s;
                    border-radius: 5px;
                }

                .card:hover {
                    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
                }

                .card img {
                    height: 300px;
                    object-fit: cover;
                    border-top-left-radius: 5px;
                    border-top-right-radius: 5px;
                }

                .card-body {
                    padding: 20px;
                }

                .card-title {
                    font-size: 24px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }

                .card-text {
                    margin-bottom: 5px;
                }

                .btn {
                    margin-top: 10px;
                }
            </style>
        </head>
        <body>
        <div class="container">
            <div class="card">
                <img src="<?php echo $producto['imagen']; ?>" class="card-img-top" alt="<?php echo $producto['nombre']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                    <p class="card-text">Tipo: <?php echo $producto['tipo']; ?></p>
                    <p class="card-text">Precio: $<?php echo $producto['precio']; ?></p>
                    <p class="card-text">Stock: <?php echo $producto['stock']; ?></p>
                    <p class="card-text">Color: <?php echo $producto['color']; ?></p>
                    <!-- Formulario de compra -->
                    <form id="compra-form" action="procesar_compra.php" method="POST" onsubmit="return validarCompra()">
                        <!-- Campos ocultos para enviar la información necesaria -->
                        <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                        <input type="hidden" name="nombre_producto" value="<?php echo $producto['nombre']; ?>">
                        <input type="hidden" name="stock" value="<?php echo $producto['stock']; ?>">
                        <div class="form-group">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" max="<?php echo $producto['stock']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="metodo_pago">Método de pago:</label>
                            <select id="metodo_pago" name="metodo_pago" class="form-control" required>
                                <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                                <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                                <option value="Pago en OXXO">Pago en OXXO</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="comprar-btn">Comprar</button>
                        <a href="tienda.php" class="btn btn-secondary">Volver a la lista de productos</a>
                    </form>
                </div>
            </div>
        </div>
        </body>
        </html>
        <?php
    } else {
        echo "<p>No se encontró el producto.</p>";
    }
} else {
    echo "<p>ID de producto no válido.</p>";
}

$conexion->close();
?>
