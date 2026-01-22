<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Informatica100*";
$database = "estetica";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el período del POST
$periodo = $_POST['periodo'];

// Llamar a la función de MySQL
$sql = "CALL resumen_ventas_por_periodo(?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $periodo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Mostrar el resultado en una tabla
    echo "<h2>Resumen de Ventas por $periodo</h2>";
    echo "<table>";
    echo "<tr><th>Período</th><th>Total Ventas</th></tr>";
    while($row = $result->fetch_assoc()) {
        // Imprimir cada fila de resultados
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados.";
}

$stmt->close();
$conn->close();
?>
