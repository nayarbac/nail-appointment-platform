<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Estilo para eliminar el borde blanco alrededor de los elementos del menú lateral */
        .sidebar .nav-item .nav-link {
            border: none !important;
            outline: none !important;
        }

        /* Estilo para el menú lateral */
        .sidebar {
            background-color: #F05ECA; 
            z-index: 1030;
        }

        .sidebar .navbar-nav {
            background-color: #F05ECA; 
            padding-top: 20px; 
        }

        .sidebar .navbar-nav .nav-item .nav-link {
            color: #fff; 
        }

        .sidebar .navbar-nav .nav-item .nav-link:hover {
            background-color: #d54ac6; 
        }

        .sidebar-right {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background-color: #F05ECA;
            padding: 20px;
            z-index: 1030;
        }

        .sidebar-right ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-right li {
            margin-bottom: 10px;
        }

        .sidebar-right a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .sidebar-right a:hover {
            background-color: #d54ac6;
        }

        .boton-cerrar {
            background-color: transparent;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 0;
            margin: 0;
            position: absolute;
            top: 5px;
            right: 10px;
            z-index: 1031;
        }

        .icono-apagado {
            width: 30px;
            height: 30px;
            background-image: url('boton-de-apagado.png');
            background-size: cover;
        }

        .bg-femenino {
            background-color: #E78EE5; /* Fondo rosado */
            height: 50px;
            width: 100%;
            z-index: 1020;
        }

        .estilo-imagen {
            margin-top: 40px;
        }

        .estilo-imagen .card {
            width: 110%;
            margin-bottom: 20px;
        }

        .estilo-imagen .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .estilo-imagen .card-body {
            text-align: center;
        }

        @media (min-width: 992px) {
            .estilo-imagen .row {
                margin-left: 350px;
                margin-right: -15px;
            }
        }

        .boton-cita {
            position: absolute;
            top: 80px;
            right: 30px;
            z-index: 1031;
            background-color: #c74e88;
            font-size: 25px;
            border-color: #c74e88;
            color: #fff;
            padding: 35px 50px;
            border-radius: 4px;
            cursor: pointer;
        }

        .boton-cita:hover {
            background-color: #a04174;
            border-color: #a04174;
        }
    </style>
</head>
<body style="background-color: #FFC9F4;">
<div class="bg-femenino fixed-top"></div>

<h1 style="text-align: center; margin-top: 70px;">Estilos disponibles</h1>

<a href="fondo.html" class="boton-cerrar"> 
    <div class="icono-apagado"></div>
</a>

<a href="seleccion.php" class="boton-cita">Agenda tu cita aquí</a>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 sidebar fixed-top">
            <div class="logo">
                <img src="logo.png" width="150" height="auto" alt="Logo">
            </div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="menu.php">Estilos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="servicios.html">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tienda.php">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="perfil.php">Perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="fondo.html">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-lg-9 estilo-imagen">
            <div class="row">
            <?php
$conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

$sql = "SELECT * FROM estilos";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4">';
        echo '<div class="card">';
        echo '<img src="' . $row["imagen"] . '" alt="' . $row["nombre"] . '" class="card-img-top">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row["nombre"] . '</h5>';
        echo '<p class="card-text">Precio: $' . $row["precio"] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No hay estilos disponibles";
}

$conexion->close();
?>
            </div>
        </div>
       
        <div class="col-lg-3">
            <div class="sidebar-right">
                <ul>
                    <li><a href="#"><i class="fab fa-facebook-f mr-2"></i> Facebook</a></li>
                    <li><a href="#"><i class="fab fa-twitter mr-2"></i> Twitter</a></li>
                    <li><a href="#"><i class="fab fa-instagram mr-2"></i> Instagram</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
