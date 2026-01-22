<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "Informatica100*";
$database = "estetica";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para encontrar el servicio más solicitado
$sql = "SELECT nombre_servicio
        FROM (
            SELECT nombre_servicio, COUNT(*) as cantidad
            FROM citas
            GROUP BY nombre_servicio
            ORDER BY COUNT(*) DESC
            LIMIT 1
        ) AS subquery";

$result = $conn->query($sql);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Mostrar el nombre del servicio más solicitado
    while($row = $result->fetch_assoc()) {
        echo "<p>El servicio más solicitado es: " . $row["nombre_servicio"] . "</p>";
    }
} else {
    echo "No se encontraron resultados";
}

// Cerrar la conexión
$conn->close();
?>
