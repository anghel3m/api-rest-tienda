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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <h1>✏️ Editar Producto</h1>

    <form action="update.php" method="POST" class="formulario">
        <input type="hidden" name="id" value="<?= $producto['id'] ?>">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required>

        <label class="checkbox">
            <input type="checkbox" name="active" value="1" <?= $producto['active'] ? 'checked' : '' ?>>
            Activo
        </label>

        <button type="submit">Actualizar</button>
    </form>

    <a href="../index.php" class="volver">⬅️ Volver</a>
</body>
</html>
