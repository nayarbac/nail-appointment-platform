<?php
// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

// Consultar los productos desde la base de datos
$sql = "SELECT * FROM productos";
$result = $conexion->query($sql);

// Verificar si la consulta fue exitosa
if ($result === false) {
    // Imprimir el mensaje de error y detener la ejecución del script
    die("Error al ejecutar la consulta: " . $conexion->error);
}

// Mostrar los productos en cards
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4 mt-5">';
        echo '<div class="card">';
        echo '<img src="' . $row["imagen"] . '" class="card-img-top" alt="' . $row["nombre"] . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row["nombre"] . '</h5>';
        echo '<p class="card-text">Precio: $' . $row["precio"] . '</p>';
        echo '<p class="card-text">Stock: ' . $row["stock"] . '</p>';
        echo '<p class="card-text">Color: ' . $row["color"] . '</p>';
        // Agregar botones de compra y agregar al carrito
        echo '<button class="btn btn-primary boton-comprar">Comprar</button>';
        echo '<button class="btn btn-success boton-carrito">Agregar al carrito</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No hay productos disponibles";
}

// Cerrar la conexión
$conexion->close();
?>
