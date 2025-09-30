<?php
require_once __DIR__ . "/config/database.php";

$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Vinculamos el CSS central -->
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <h1>📦 Lista de Productos</h1>
    <a href="src/create.php" class="nuevo">➕ Nuevo producto</a>

    <table class="tabla">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Precio</th><th>Activo</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productos as $p): ?>
            <tr>
                <td data-label="ID"><?= $p['id'] ?></td>
                <td data-label="Nombre"><?= htmlspecialchars($p['nombre']) ?></td>
                <td data-label="Precio">$<?= number_format($p['precio'], 2) ?></td>
                <td data-label="Activo"><?= $p['active'] ? '✅ Sí' : '❌ No' ?></td>
                <td data-label="Acciones" class="acciones">
                    <a href="src/edit.php?id=<?= $p['id'] ?>" class="editar">✏️ Editar</a>
                    <a href="src/delete.php?id=<?= $p['id'] ?>" class="eliminar" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">🗑️ Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
