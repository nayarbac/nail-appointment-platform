<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header("Location: login.html");
    exit();
}

$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

$clienteID = $_SESSION['ID'];
$nuevoNombre = $_POST['nombre'];
$nuevoTelefono = $_POST['telefono'];
$nuevoCorreo = $_POST['correo'];
$nuevoDomicilio = $_POST['domicilio'];
$nuevaContrasena = $_POST['contrasena']; // Si tienes un campo de contraseña en el formulario
$nuevoTipoUsuario = $_SESSION['tipo_usuario']; // No permitimos cambiar el tipo de usuario

// Llamar a la función para actualizar los datos del cliente
$resultado = actualizarCliente($clienteID, $nuevoNombre, $nuevoTelefono, $nuevoCorreo, $nuevoDomicilio, $nuevaContrasena, $nuevoTipoUsuario);

if ($resultado) {
    echo "Datos actualizados correctamente.";
} else {
    echo "Error al actualizar los datos.";
}

// Cerrar la conexión
$conexion->close();
?>
