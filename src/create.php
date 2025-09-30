<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <h1>➕ Agregar Producto</h1>

    <form action="store.php" method="POST" class="formulario">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" required>

        <button type="submit">Guardar</button>
    </form>

    <a href="../index.php" class="volver">⬅️ Volver</a>
</body>
</html>
