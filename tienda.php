<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
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
            background-color: #F05ECA; /* Color rosado */
            z-index: 1030;
        }

        .sidebar .navbar-nav {
            background-color: #F05ECA; /* Color rosado */
            padding-top: 20px; /* Añade espacio arriba */
        }

        .sidebar .navbar-nav .nav-item .nav-link {
            color: #fff; /* Color blanco para los enlaces */
        }

        .sidebar .navbar-nav .nav-item .nav-link:hover {
            background-color: #d54ac6; /* Color de fondo al pasar el ratón */
        }
        /* Estilos CSS aquí */
        .card {
            margin-left: 20px; 
            border-radius: 20px; 
            overflow: hidden; 
            transition: transform 0.3s; 
            height: 620px; 
        }

        .card:hover {
            transform: scale(1.05); 
        }

        .card-body {
            padding: 15px; 
        }

        .card-text {
            text-align: center;
        }

        @media (min-width: 992px) {
            .col-lg-9 {
                margin-left: 320px; 
            }
        }

        .card-img-top {
            height: 300px; 
            object-fit: cover; 
        }

        .boton-comprar,
        .boton-carrito {
            margin-top: 10px; 
        }

        /* Ajuste de tamaño para el botón de búsqueda */
        .btn-buscar {
            font-size: 0.8rem; /* Reducir el tamaño de la fuente */
            width: 80%;
        }

        .titulo-tienda {
            margin-top: -20px;
            margin-left: 100px;
        }
    </style>
</head>
<body style="background-color: #FFC9F4;">

<!-- Formulario de búsqueda --> 
<div class="container-fluid">
    <form method="POST" action="" class="row mb-3 mt-3">
        <div class="col-sm-8 offset-sm-2">
            <div class="form-group">
                <input type="text" class="form-control" name="buscar" placeholder="Buscar productos">
            </div>
        </div>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-primary btn-block btn-buscar" name="submit">Buscar</button>
        </div>
    </form>
</div>

<!-- Título de la tienda -->
<div class="container">
    <div class="row">
        <div class="col-sm-12 titulo-tienda">
        <h1>Bienvenido a la tienda - Que vas a llevar hoy?<?php echo obtenerNombreUsuario(); ?></h1>
        </div>
    </div>
</div>

<a href="carrito.php"><img src="carrito.png" alt="Logo" style="position: absolute; top: 10px; right: 10px; height: 30px;"></a>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 sidebar fixed-top" style="background-color: #F05ECA; z-index: 1030;">
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
        <div class="col-lg-9 pl-lg-5">
            <div class="row">
                <?php
                // Conexión a la base de datos
                $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

                if ($conexion->connect_error) {
                    die("Error al conectar con la base de datos: " . $conexion->connect_error);
                }

             
if (isset($_POST['buscar'])) {
    $busqueda = $_POST['buscar']; 
   
    $sql = "CALL BuscarProductos('$busqueda')"; 
} else {
   
    $sql = "SELECT * FROM productos WHERE stock > 0";
}


                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4 mt-5">';
                        echo '<div class="card">'; // Aumenta el tamaño de la tarjeta
                        echo '<a href="compra.php?id=' . $row["id_producto"] . '">';
                        echo '<img src="' . $row["imagen"] . '" class="card-img-top" alt="' . $row["nombre"] . '">';
                        echo '</a>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $row["nombre"] . '</h5>';
                        echo '<p class="card-text">Tipo: ' . $row["tipo"] . '</p>';
                        echo '<p class="card-text">Precio: $' . $row["precio"] . '</p>';
                        echo '<p class="card-text">Stock: ' . $row["stock"] . '</p>';
                        // Botón para comprar
                        echo '<a href="compra.php?id=' . $row["id_producto"] . '" class="btn btn-primary btn-block boton-comprar">Comprar</a>'; // Enlace al botón "Comprar"ra que ocupe todo el ancho de la tarjeta
                        // Enlace para agregar al carrito
                        echo '<a href="agregar_al_carrito.php?id=' . $row["id_producto"] . '&nombre=' . $row["nombre"] . '&precio=' . $row["precio"] . '" class="btn btn-success btn-block boton-carrito">Agregar al carrito</a>'; // Modifica el enlace para que ocupe todo el ancho de la tarjeta
                        echo '</div></div></div>';
                    }
                } else {
                    echo "No se encontraron productos.";
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

<?php

function obtenerNombreUsuario() {
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

   
    if (isset($_SESSION['correo'])) {
        
        $conexion = new mysqli("localhost", "root", "Informatica100*", "estetica");

        if ($conexion->connect_error) {
            die("Error al conectar con la base de datos: " . $conexion->connect_error);
        }

        // Consulta SQL para obtener el nombre de usuario
        $correo = $_SESSION['correo'];
        $sql = "SELECT nombre FROM clientes WHERE correo = '$correo'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            // Retorna el nombre de usuario
            $row = $resultado->fetch_assoc();
            return ' - ' . $row['nombre'];
        } else {
            return '';
        }

        $conexion->close();
    } else {
        return '';
    }
}
?>
</body>
</html>
