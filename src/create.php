<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
</head>
<body>
    <h1>Agregar Producto</h1>
    <form action="store.php" method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" required><br><br>

        <button type="submit">Guardar</button>
    </form>
    <a href="../public/index.php">⬅️ Volver</a>
</body>
</html>
