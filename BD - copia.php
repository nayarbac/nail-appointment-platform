<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Funciones, Procedimientos y Vistas</title>
</head>
<body>
    <h1>Consulta de Funciones, Procedimientos y Vistas</h1>
    
    <?php
    // Establecer la conexión con la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "Informatica100*";
    $dbname = "estetica";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para obtener los procedimientos almacenados
    $sql_procedures = "SHOW PROCEDURE STATUS WHERE Db = 'estetica'";
    $result_procedures = $conn->query($sql_procedures);

    if ($result_procedures->num_rows > 0) {
        // Mostrar los procedimientos en una tabla
        echo "<h2>Procedimientos Almacenados:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Nombre</th><th>Definidor</th><th>Modificado</th></tr>";
        while($row = $result_procedures->fetch_assoc()) {
            echo "<tr><td>".$row["Name"]."</td><td>".$row["Definer"]."</td><td>".$row["Modified"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron procedimientos almacenados.";
    }

    // Consulta para obtener las vistas
    $sql_views = "SHOW FULL TABLES IN estetica WHERE TABLE_TYPE LIKE 'VIEW'";
    $result_views = $conn->query($sql_views);

    if ($result_views->num_rows > 0) {
        // Mostrar las vistas en una tabla
        echo "<h2>Vistas:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Nombre de la Vista</th></tr>";
        while($row = $result_views->fetch_assoc()) {
            echo "<tr><td>".$row["Tables_in_estetica"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron vistas.";
    }

    $conn->close();
    ?>
</body>
</html>
