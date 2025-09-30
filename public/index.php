.
<?php
require_once "../config/database.php";

$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
</head>
<body>
    <h1>Productos</h1>
    <a href="../src/create.php">➕ Nuevo producto</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th><th>Nombre</th><th>Precio</th><th>Activo</th><th>Acciones</th>
        </tr>
        <?php foreach($productos as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['nombre'] ?></td>
            <td><?= $p['precio'] ?></td>
            <td><?= $p['active'] ? 'Sí' : 'No' ?></td>
            <td>
                <a href="../src/edit.php?id=<?= $p['id'] ?>">✏️ Editar</a> | 
                <a href="../src/delete.php?id=<?= $p['id'] ?>" onclick="return confirm('¿Seguro?')">🗑️ Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
