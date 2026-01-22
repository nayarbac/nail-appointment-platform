<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores seleccionados del formulario
    $servicioSeleccionado = $_POST["servicio"];
    $estiloSeleccionado = $_POST["estilo"];

    // Obtener los precios de los servicios y estilos seleccionados
    $precioServicio = obtenerPrecioServicio($servicioSeleccionado);
    $precioEstilo = obtenerPrecioEstilo($estiloSeleccionado);

    // Calcular la suma de los precios
    $precioTotal = $precioServicio + $precioEstilo;

    // Mostrar el precio total
    echo "El precio total es: $" . $precioTotal;
} else {
    // Redirigir si no se ha enviado el formulario
    header("Location: servicios.html");
}

// Función para obtener el precio del servicio desde la base de datos
function obtenerPrecioServicio($servicio)
{
    // Definir los precios de los servicios
    $preciosServicios = [
        "uñas postizas" => 200,
        "Decoración" => 300,
        "Reparación" => 150
        // Agrega más precios aquí según sea necesario
    ];

    // Obtener el precio del servicio seleccionado
    return $preciosServicios[$servicio] ?? 0;
}

// Función para obtener el precio del estilo desde el formulario
function obtenerPrecioEstilo($estilo)
{
    // Verificar si se ha enviado el formulario y si se ha seleccionado un estilo
    if (isset($_POST['estilo']) && !empty($_POST['estilo'])) {
        // Obtener el precio del estilo seleccionado del formulario
        $precioEstilo = $_POST['estilo'];
        // Extraer el precio del estilo desde el atributo de datos 'data-precio'
        $precioEstilo = filter_var($precioEstilo, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        return floatval($precioEstilo);
    }
    return 0; // Devolver 0 si no se ha seleccionado ningún estilo
}
?>
