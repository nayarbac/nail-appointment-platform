<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

   
    if ($conexion->connect_error) {
        die("Error al conectar con la base de datos: " . $conexion->connect_error);
    }

   
    $nombreEstilo = $_POST["nombreEstilo"];
    $precio = $_POST["precio"]; 

  
    $imagenEstilo = $_FILES["imagenEstilo"]["name"];
    $imagenTmp = $_FILES["imagenEstilo"]["tmp_name"];
    $imagenRuta = "uploads/" . $imagenEstilo;

    
    if (!file_exists("uploads")) {
        mkdir("uploads");
    }

    if (move_uploaded_file($imagenTmp, $imagenRuta)) {
        
        $sql = "INSERT INTO estilos (nombre, imagen, precio) VALUES ('$nombreEstilo', '$imagenRuta', '$precio')";
        if ($conexion->query($sql) === TRUE) {
            echo "<script>alert('Estilo agregado exitosamente');</script>";
        } else {
            echo "<script>alert('Error al agregar el estilo: " . $conexion->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error al subir la imagen');</script>";
    }

    // Cerrar la conexión
    $conexion->close();
    echo "<script>window.history.back();</script>"; // Regresar a la página anterior
}
?>
