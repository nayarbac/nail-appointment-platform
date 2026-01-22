<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $servidor = "localhost";
    $usuario = "root";
    $contrasena_bd = "Informatica100*";
    $nombre_bd = "estetica";

    $conexion = new mysqli($servidor, $usuario, $contrasena_bd, $nombre_bd);

    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $domicilio = $_POST["domicilio"];
    $contrasena = $_POST["contrasena"];
    $tipo_usuario = "cliente";

    // Verificar si algún campo está vacío
    if (empty($nombre) || empty($correo) || empty($domicilio) || empty($contrasena)) {
        die("Error: Todos los campos son obligatorios.");
    }

    
    $sql = "INSERT INTO clientes (nombre, telefono, correo, domicilio, contrasena, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?)";

    
    $stmt = $conexion->prepare($sql);

   
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("ssssss", $nombre, $telefono, $correo, $domicilio, $contrasena, $tipo_usuario);

    
    if ($stmt->execute()) {
        // Registro exitoso, mostrar mensaje de alerta y redirigir al login
        echo '<script>';
        echo 'alert("Registro exitoso de usuario.");';
        echo 'window.location.href = "fondo.html";'; // Redirige al usuario al login
        echo '</script>';
    } else {
        echo "Error al registrar usuario: " . $stmt->error;
    }

    // Cierra la conexión
    $conexion->close();

}
?>
