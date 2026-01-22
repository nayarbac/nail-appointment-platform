<?php
// Establecer conexión a la base de datos (reemplaza con tus propios datos)
$servername = "localhost";
$username = "root";
$password = "Informatica100*";
$database = "estetica";

$conn = new mysqli($servername, $username, $password, $database);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recoger datos del formulario
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$color = $_POST['color'];

// Procesar la imagen
$imagen = $_FILES['imagen']['name'];
$imagen_temp = $_FILES['imagen']['tmp_name'];
// Carpeta donde se guardarán las imágenes (en este caso, la misma carpeta que el script PHP)
$carpeta_destino = '';

// Mover la imagen a la carpeta de destino
if (move_uploaded_file($imagen_temp, $imagen)) {
    echo "<script>alert('La imagen se ha subido correctamente.');</script>";
} else {
    echo "<script>alert('Error al subir la imagen.');</script>";
}

// Insertar datos en la tabla
$sql = "INSERT INTO productos (nombre, tipo, precio, stock, color, imagen)
        VALUES ('$nombre', '$tipo', '$precio', '$stock', '$color', '$imagen')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Articulo insertado exitosamente');</script>";
} else {
    echo "<script>alert('Error al insertar el registro: " . $conn->error . "');</script>";
}

$conn->close();
?>
<script>
    window.history.back(); // Regresar a la página anterior
</script>
