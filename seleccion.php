<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="servicios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <style>
        
         .sidebar .nav-item .nav-link {
            border: none !important;
            outline: none !important;
        }

        
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
        .fecha-container {
            display: inline-block;
            margin-left: 20px;
        }

        .bg-femenino {
            background-color: #E78EE5;
        }

        /* Estilo para los días sábado y domingo */
        .ui-datepicker-week-end .ui-state-default {
            color: red !important;
        }

        /* Personalización del calendario */
        .ui-datepicker {
            width: 250px;
        }

        .ui-datepicker-header {
            background: #f05eca;
            color: #fff;
        }

        .ui-datepicker-calendar {
            margin-top: 10px;
        }

        .ui-datepicker-calendar tbody a {
            color: #333;
        }

        .ui-datepicker-calendar tbody a:hover {
            background: #f05eca;
            color: #fff;
        }

        /* Estilo para el botón "Regresar" */
        #btn-regresar {
            position: fixed;
            top: 50px; 
            left: 0; 
            background-color: #F05ECA;
            color: #fff;
            border: none;
            padding: 10px 20px;
            z-index: 1025; 
        }
    </style>
</head>
<body style="padding-top: 100px;">

<div class="bg-femenino fixed-top" style="height: 50px; width: 100%; z-index: 1020"></div>


<button id="btn-regresar" class="btn">Regresar</button>

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
        
        <div class="col-lg-9 offset-lg-3">
            <h1>Selecciona un servicio, un estilo, una fecha y una hora:</h1>
            <form id="formulario" method="POST" action="confirmacioncita.php">
                <div class="form-group">
                    <label for="servicio">Servicio:</label>
                    <select name="servicio" id="servicio" class="form-control">
                        <option value="uñas postizas">Uñas Postizas - $200</option>
                        <option value="Decoración">Decoración - $300</option>
                        <option value="Reparación">Reparación - $150</option>
                       
                    </select>
                </div>

                <div class="form-group">
                    <label for="estilo">Estilo:</label>
                    <select name="estilo" id="estilo" class="form-control">
                        <?php
                        // Conexión a la base de datos
                        $conexion = mysqli_connect("localhost", "root", "Informatica100*", "estetica");

                        // Verificar la conexión
                        if (mysqli_connect_errno()) {
                            echo "Error de conexión a MySQL: " . mysqli_connect_error();
                        }

                        // Consulta para obtener los estilos
                        $consulta = "SELECT nombre, precio FROM estilos";

                        // Ejecutar la consulta
                        $resultado = mysqli_query($conexion, $consulta);

                      
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='" . $fila['nombre'] . "' data-precio='" . $fila['precio'] . "'>" . $fila['nombre'] . " - $" . $fila['precio'] . "</option>";
                        }

                   
                        mysqli_free_result($resultado);

                        // Cerrar la conexión
                        mysqli_close($conexion);
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fecha">Fecha: (Recuerda que los sabados y domingos no trabajamos)</label>
                    <input type="text" id="fecha" name="fecha" class="form-control">
                </div>

                <div class="form-group">
                    <label for="hora">Hora: (Recuerda que solo tenemos servicio de 8 AM a 7 PM)</label>
                    <input type="text" id="hora" name="hora" class="form-control clockpicker" data-autoclose="true" data-placement="bottom" data-align="top" data-donetext="Listo">
                </div>

                <br><br>
                <button type="submit" class="btn btn-success">Confirmar Cita</button>
            </form>

            <!-- Div para mostrar el precio, la fecha y la hora seleccionada -->
            <div id="resultado"></div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    $(function() {
        $("#fecha").datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0, 
            beforeShowDay: function(date) {
                var day = date.getDay(); // Obtener el día de la semana (0 para domingo, 1 para lunes, etc.)
               
                if (day === 0 || day === 6) {
                    return [true, "ui-datepicker-week-end"];
                } else {
                    return [true, ""];
                }
            }
        });

        
        $('.clockpicker').clockpicker({
            placement: 'bottom',
            align: 'top',
            donetext: 'Listo',
            autoclose: true,
            twelvehour: false, 
            default: '09:00', // Establecer la hora predeterminada a las 9 am
            min: '09:00', // Establecer la hora mínima a las 9 am
            max: '19:00', // Establecer la hora máxima a las 7 pm
            afterDone: function() {
                validarHora(); 
            }
        });
    });

    function validarHora() {
        // Obtener la hora seleccionada
        var horaSeleccionada = $("#hora").val();

        // Convertir la hora seleccionada a un objeto Date
        var horaSeleccionadaObj = new Date("01/01/2000 " + horaSeleccionada);

       
        var horaMinima = new Date();
        horaMinima.setHours(9, 0, 0); 
        var horaMaxima = new Date();
        horaMaxima.setHours(19, 0, 0); 

      
        var horaActual = new Date();

        // Verificar si la hora seleccionada está dentro del rango permitido
        if (horaSeleccionadaObj < horaMinima || horaSeleccionadaObj > horaMaxima || horaSeleccionadaObj.getHours() < horaActual.getHours() || (horaSeleccionadaObj.getHours() === horaActual.getHours() && horaSeleccionadaObj.getMinutes() < horaActual.getMinutes())) {
            // Mostrar un mensaje de error
            alert("Por favor, selecciona una hora dentro del rango de 9 am a 7 pm y que sea posterior a la hora actual.");
            // Restablecer la hora a la mínima permitida (9 am)
            $("#hora").val("09:00");
        }
    }

    function calcularPrecio() {
        // Obtener los valores seleccionados del formulario
        var servicioSeleccionado = $("#servicio").val();
        var estiloSeleccionado = $("#estilo").val();
        var precioEstiloSeleccionado = parseFloat($("#estilo").find(":selected").data("precio"));
        var fechaSeleccionada = $("#fecha").val();
        var horaSeleccionada = $("#hora").val();

       
        var precioServicio = 0;
        switch (servicioSeleccionado) {
            case "uñas postizas":
                precioServicio = 200;
                break;
            case "Decoración":
                precioServicio = 300;
                break;
            case "Reparación":
                precioServicio = 150;
                break;
           
        }

        
        var precioTotal = precioServicio + precioEstiloSeleccionado;

        // Mostrar el precio total, la fecha y la hora seleccionada en el div correspondiente
        $("#resultado").html("El precio total es: $" + precioTotal + "<br>El día de tu cita es: " + fechaSeleccionada + "<br>La hora de tu cita es: " + horaSeleccionada);
    }
</script>
</body>
</html>
