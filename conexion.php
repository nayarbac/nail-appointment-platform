<?php
$servername = "localhost";
$username = "root";
$password = "Informatica100*";
$dbname = "estetica";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}
echo "Conexión exitosa";



// Cerrar la conexión
$conn->close();
?>
