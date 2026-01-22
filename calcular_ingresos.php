<?php
// Verificar si se recibieron las fechas del formulario
if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
    // Conectar a la base de datos (reemplazar con tus credenciales)
    $servername = "localhost";
    $username = "root";
    $password = "Informatica100*";
    $dbname = "estetica";

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    // Obtener fechas del formulario
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    
    // Consultar el total de ingresos utilizando la función de la base de datos
    $sql = "SELECT calcular_total_ingresos('$startDate', '$endDate') AS total_ingresos";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['total_ingresos'];
    } else {
        echo "0";
    }
    
    $conn->close();
}
?>
