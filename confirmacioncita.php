<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['correo'])) {
    // Obtener los datos del formulario
    $nombre_servicio = $_POST['servicio'];
    $nombre_estilo = $_POST['estilo'];
    // Convertir la fecha al formato YYYY-MM-DD
    $fecha = date("Y-m-d", strtotime($_POST['fecha']));
    $hora = $_POST['hora'];
    
    // Obtener el correo electrónico del usuario logueado
    $correo = $_SESSION['correo'];
    
    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

    if ($conexion->connect_error) {
        die("Error al conectar con la base de datos: " . $conexion->connect_error);
    }

    // Consulta para obtener el nombre y el ID del cliente
    $sql = "SELECT ID, nombre FROM clientes WHERE correo = '$correo'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
       
        $fila = $resultado->fetch_assoc();
        $nombre_cliente = $fila['nombre'];
        $id_cliente = $fila['ID'];
    } else {
       
        echo "<script>alert('No se encontraron datos del usuario.');";
        echo "window.location.href = 'pagina_de_seleccion_de_cita.php';</script>";
        exit(); 
    }

    // Obtener el número de citas programadas para la fecha seleccionada
    $sql_num_citas = "SELECT COUNT(*) AS num_citas FROM citas WHERE fecha = '$fecha'";
    $resultado_num_citas = $conexion->query($sql_num_citas);
    $row_num_citas = $resultado_num_citas->fetch_assoc();
    $num_citas = $row_num_citas['num_citas'];
    
    // Verificar si se excede el límite de 6 citas por día
    if ($num_citas >= 6) {
        
        echo "<script>alert('Se ha alcanzado el límite de 6 citas para este día. Por favor, elige otra fecha.');";
        echo "window.location.href = 'seleccion.php';</script>";
    } else {
        // Obtener el día de la semana de la fecha seleccionada (0 para domingo, 1 para lunes, etc.)
        $dia_semana = date('w', strtotime($fecha));
        
        // Verificar si la fecha seleccionada es sábado (6) o domingo (0)
        if ($dia_semana == 6 || $dia_semana == 0) {
            // Mostrar mensaje de error y abortar la inserción de la cita
            echo "<script>alert('No se proporciona servicio los sábados y domingos. Por favor, elige otro día.');";
            echo "window.location.href = 'seleccion.php';</script>";
        } else {
            // Validar la hora seleccionada
            $hora_actual = date("H:i:s"); // Obtener la hora actual
            if ($hora < "09:00" || $hora > "19:00" || ($fecha == date("Y-m-d") && $hora <= $hora_actual)) {
                // Mostrar mensaje de error y abortar la inserción de la cita
                echo "<script>alert('Por favor, selecciona una hora dentro del rango de 9:00 AM a 7:00 PM y que sea posterior a la hora actual.');";
                echo "window.location.href = 'seleccion.php';</script>";
            } else {
                // Verificar si ya hay una cita programada para la misma hora o dentro del lapso de una hora
                $hora_fin_mas_una_hora = date("H:i:s", strtotime("$hora +1 hour"));
                $consulta_citas_en_rango = "SELECT COUNT(*) AS num_citas FROM citas WHERE fecha = '$fecha' AND hora >= '$hora' AND hora < '$hora_fin_mas_una_hora'";
                $resultado_citas_en_rango = $conexion->query($consulta_citas_en_rango);
                $row_citas_en_rango = $resultado_citas_en_rango->fetch_assoc();
                $num_citas_en_rango = $row_citas_en_rango['num_citas'];
                
                if ($num_citas_en_rango > 0) {
                    // Mostrar mensaje de error y abortar la inserción de la cita
                    echo "<script>alert('Ya hay una cita programada dentro de la misma hora o en el lapso de una hora. Por favor, elige otro horario.');";
                    echo "window.location.href = 'seleccion.php';</script>";
                } else {
                    // Preparar la consulta SQL para insertar la cita en la base de datos
                    $consulta_insertar_cita = "INSERT INTO citas (fecha, hora, nombre_servicio, nombre_estilo) VALUES ('$fecha', '$hora', '$nombre_servicio', '$nombre_estilo')";
                    
                    // Ejecutar la consulta para insertar la cita
                    if ($conexion->query($consulta_insertar_cita) === TRUE) {
                        $id_cita = $conexion->insert_id;
                        
                        // Obtener el precio del servicio seleccionado
                        $sql_precio_servicio = "SELECT precio FROM servicios WHERE nombre_servicio = '$nombre_servicio'";
                        $resultado_precio_servicio = $conexion->query($sql_precio_servicio);
                        $row_precio_servicio = $resultado_precio_servicio->fetch_assoc();
                        $precio_servicio = $row_precio_servicio['precio'];
                        
                        // Obtener el precio del estilo seleccionado
                        $sql_precio_estilo = "SELECT precio FROM estilos WHERE nombre = '$nombre_estilo'";
                        $resultado_precio_estilo = $conexion->query($sql_precio_estilo);
                        $row_precio_estilo = $resultado_precio_estilo->fetch_assoc();
                        $precio_estilo = $row_precio_estilo['precio'];
                        
                        // Calcular el precio total
                        $precio_total = $precio_servicio + $precio_estilo;
                        
                        // Preparar la consulta SQL para insertar el detalle de la cita en la base de datos
                        $consulta_insertar_detalle = "INSERT INTO detalle_cita (id_cita, cliente, id_cliente, nombre_servicio, nombre_estilo, fecha, hora, precio_total) VALUES ('$id_cita', '$nombre_cliente', '$id_cliente', '$nombre_servicio', '$nombre_estilo', '$fecha', '$hora', '$precio_total')";
                        
                        // Ejecutar la consulta para insertar el detalle de la cita
                        if ($conexion->query($consulta_insertar_detalle) === TRUE) {
                            // Mostrar mensaje de cita confirmada
                            echo "<script>alert('Cita confirmada.');";
                            echo "window.location.href = 'seleccion.php';</script>";
                        } else {
                            echo "Error al programar la cita: " . $conexion->error;
                        }
                    } else {
                        echo "Error al programar la cita: " . $conexion->error;
                    }
                }
            }
        }
    }

   
    $conexion->close();
} else {
    // Si se intenta acceder al script directamente sin enviar el formulario o sin sesión iniciada, redireccionar a una página de error o a donde desees.
    header("Location: seleccion.php");
    exit();
}
?>
