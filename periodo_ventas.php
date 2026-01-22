<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Resumen de Ventas por Período</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Generar Resumen de Ventas por Período</h1>
    <form action="generar_resumen_ventas.php" method="post">
        <label for="periodo">Selecciona el período:</label>
        <select name="periodo" id="periodo">
            <option value="dia">Día</option>
            <option value="semana">Semana</option>
            <option value="mes">Mes</option>
        </select>
        <button type="submit">Generar Resumen</button>
    </form>
</body>
</html>
