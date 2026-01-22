<?php
// Obtener los parámetros enviados desde el formulario
$idProducto = $_GET['id'];
$cantidad = $_GET['cantidad'];

// Establecer la conexión con la base de datos
$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

// Verificar si hay algún error de conexión
if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

// Obtener el nombre de usuario del carrito (debes obtenerlo de tu sistema de autenticación)
$nombreUsuario = 'usuario'; // Reemplaza 'usuario' con la forma en que obtienes el nombre de usuario (por ejemplo, desde la sesión)

// Verificar si hay un carrito activo para el usuario
$sqlCarritoActivo = "SELECT * FROM carrito WHERE estado = 'en_espera' AND nombre_usuario = '$nombreUsuario'";
$resultadoCarrito = $conexion->query($sqlCarritoActivo);

if ($resultadoCarrito->num_rows > 0) {
    // Si hay un carrito activo, obtener su ID
    $rowCarrito = $resultadoCarrito->fetch_assoc();
    $idCarrito = $rowCarrito['id_carrito'];
} else {
    // Si no hay un carrito activo, crear un nuevo carrito
    $idCarrito = crearNuevoCarrito($conexion, $nombreUsuario);
}

// Agregar el producto al carrito
agregarProductoACarrito($conexion, $idCarrito, $idProducto, $cantidad);

// Función para crear un nuevo carrito
function crearNuevoCarrito($conexion, $nombreUsuario) {
    $sql = "INSERT INTO carrito (estado, total_carrito, nombre_usuario) VALUES ('en_espera', 0, '$nombreUsuario')";
    if ($conexion->query($sql) === TRUE) {
        return $conexion->insert_id;
    } else {
        die("Error al crear un nuevo carrito: " . $conexion->error);
    }
}

// Función para agregar un producto al carrito
function agregarProductoACarrito($conexion, $idCarrito, $idProducto, $cantidad) {
    // Aquí implementa la lógica para agregar el producto al carrito
    // Por ejemplo, actualiza el total del carrito, agrega un nuevo detalle de producto, etc.
}

// Cerrar la conexión
$conexion->close();
?>
