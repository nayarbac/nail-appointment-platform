<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Informatica100*";
$dbname = "estetica";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el ID del cliente desde el formulario
if (isset($_POST["cliente"])) {
    // Obtener el ID del cliente seleccionado desde el formulario
    $cliente_id = $_POST["cliente"];

    // Consulta para calcular el total de compras del cliente utilizando la función creada
    $sql = "SELECT calcular_total_compras_cliente($cliente_id) AS total_compras";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Mostrar el resultado
            $row = $result->fetch_assoc();
            echo "Total de compras del cliente: $" . $row["total_compras"];
        } else {
            echo "No se encontraron resultados para el cliente seleccionado.";
        }
    } else {
        echo "Error al ejecutar la consulta: " . $conn->error;
    }
} else {
    echo "No se ha recibido el ID del cliente.";
}

$conn->close();
?>
