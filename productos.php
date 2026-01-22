<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro de Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fce4ec; /* Fondo rosa */
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #ff69b4; /* Rosa suave */
            text-align: center;
            margin-top: 30px;
        }

        form {
            background-color: #fff; /* Fondo blanco */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: auto;
            max-width: 500px;
        }

        label {
            color: #ff69b4; /* Rosa suave */
        }

        .form-control {
            border-color: #ff69b4; /* Rosa suave */
        }

        .btn-primary {
            background-color: #ff69b4; /* Rosa suave */
            border-color: #ff69b4; /* Rosa suave */
        }

        .btn-primary:hover {
            background-color: #ff1493; /* Rosa más intenso */
            border-color: #ff1493; /* Rosa más intenso */
        }

        .btn-regresar {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #ff69b4; /* Rosa suave */
            border-color: #ff69b4; /* Rosa suave */
            color: white;
        }

        .btn-regresar:hover {
            background-color: #ff1493; /* Rosa más intenso */
            border-color: #ff1493; /* Rosa más intenso */
        }
    </style>
</head>
<body>
    <a href="javascript:history.back()" class="btn btn-regresar">Regresar</a>
    <div class="container">
        <h2>Registro de Producto</h2>
        <form action="proceso-productos.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <input type="text" class="form-control" id="tipo" name="tipo">
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="text" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="text" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="form-group">
                <label for="color">Color:</label>
                <input type="text" class="form-control" id="color" name="color">
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen">
            </div>
            <button type="submit" class="btn btn-primary">Guardar artículo</button>
        </form>
    </div>
</body>
</html>
