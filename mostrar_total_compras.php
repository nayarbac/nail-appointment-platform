<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "Informatica100*";
$database = "estetica";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del cliente seleccionado desde la solicitud GET
$cliente_id = $_GET["cliente_id"];

// Ejecutar la función para calcular el total de compras del cliente
$sql = "SELECT contar_compras_cliente($cliente_id) AS total_compras";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $total_compras = $row["total_compras"];
    echo "El total de compras del cliente seleccionado es: $total_compras";
} else {
    echo "Error al ejecutar la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
