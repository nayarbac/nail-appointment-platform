<?php
$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$sql = "SELECT * FROM clientes WHERE correo = '$correo' AND contrasena = '$contrasena' AND estado = 'activo'";

$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    // Autenticación exitosa
    session_start();
    $_SESSION['correo'] = $correo;
    $usuario = $resultado->fetch_assoc();
    $_SESSION['user_id'] = $usuario['ID']; 
    
    // Mostrar mensaje de cuenta ingresada correctamente
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Autenticación Exitosa</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
            }
            .container {
                text-align: center;
                padding-top: 100px;
            }
            .animation {
                width: 100px;
                height: 100px;
                background-color: green;
                border-radius: 50%;
                margin: 0 auto;
                animation: pulse 1s infinite alternate;
            }
            .message {
                color: green;
                font-weight: bold;
            }
            @keyframes pulse {
                0% {
                    transform: scale(1);
                }
                100% {
                    transform: scale(1.1);
                }
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='animation'></div>
            <h2 class='message'>¡Cuenta ingresada correctamente!</h2>
            <p class='message'>Cargando...</p>
        </div>
    </body>
    </html>";

    // Redirigir después de un breve retraso (3 segundos)
    echo "<script>
            setTimeout(function() {";
    if ($usuario['tipo_usuario'] == 'administrador') {
        echo "window.location.href = 'privado.html';";
    } elseif ($usuario['tipo_usuario'] == 'cliente') {
        echo "window.location.href = 'menu.php';";
    }
    echo "}, 3000); // 3000 milisegundos = 3 segundos
          </script>";
} else {
    // Autenticación fallida
    // Mostrar animación y mensaje de cuenta ingresada incorrectamente
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Autenticación Fallida</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
            }
            .container {
                text-align: center;
                padding-top: 100px;
            }
            .animation {
                width: 100px;
                height: 100px;
                background-color: red;
                border-radius: 50%;
                margin: 0 auto;
                animation: pulse 1s infinite alternate;
            }
            .message {
                color: red;
                font-weight: bold;
            }
            @keyframes pulse {
                0% {
                    transform: scale(1);
                }
                100% {
                    transform: scale(1.1);
                }
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='animation'></div>
            <h2 class='message'>¡Cuenta ingresada incorrectamente!</h2>
            <p class='message'>Por favor, revisa tu correo electrónico y contraseña e intenta de nuevo.</p>
        </div>
    </body>
    </html>";

    // Redirigir al formulario de inicio de sesión después de un breve retraso (3 segundos)
    echo "<script>
            setTimeout(function() {
                window.location.href = 'fondo.html';
            }, 3000); // 3000 milisegundos = 3 segundos
          </script>";
}

$conexion->close();
?>
