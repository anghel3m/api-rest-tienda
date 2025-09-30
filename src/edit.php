<?php
require_once "../config/database.php";

$id = $_GET['id'] ?? null;
if (!$id) die("ID inválido");

$stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
$stmt->execute(['id' => $id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) die("Producto no encontrado");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $producto['nombre'] ?>" required><br><br>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required><br><br>

        <label>Activo:</label>
        <input type="checkbox" name="active" value="1" <?= $producto['active'] ? 'checked' : '' ?>><br><br>

        <button type="submit">Actualizar</button>
    </form>
    <a href="../public/index.php">⬅️ Volver</a>
</body>
</html>
