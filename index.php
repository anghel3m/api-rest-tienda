<?php
require_once __DIR__ . "/config/database.php";

$stmt = $pdo->query("SELECT * FROM equipos");
$equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inventario de Equipos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Vinculamos el CSS central -->
    <link rel="stylesheet" href="public/style.css">
</head>

<body>
    <h1>💻 Inventario de Equipos</h1>
    <a href="src/create.php" class="nuevo">➕ Nuevo equipo</a>
    <table class="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Serial BIOS</th>
                <th>Nombre Equipo</th>
                <th>Responsable</th>
                <th>Usuario</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>SO</th>
                <th>RAM (GB)</th>
                <th>Disco (GB)</th>
                <th>Fecha Reporte</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipos as $e): ?>
                <tr>
                    <td data-label="ID"><?= $e['id'] ?></td>
                    <td data-label="Serial BIOS"><?= $e['serial_bios'] ?></td>
                    <td data-label="Nombre Equipo"><?= $e['nombre_equipo'] ?></td>
                    <td data-label="Responsable"><?= $e['nombre_responsable'] ?? '-' ?></td>
                    <td data-label="Usuario"><?= $e['usuario'] ?? '-' ?></td>
                    <td data-label="Marca"><?= $e['marca'] ?? '-' ?></td>
                    <td data-label="Modelo"><?= $e['modelo'] ?? '-' ?></td>
                    <td data-label="SO"><?= $e['sistema_operativo'] ?? '-' ?></td>
                    <td data-label="RAM (GB)"><?= $e['ram_total_gb'] ?? '-' ?></td>
                    <td data-label="Disco (GB)"><?= $e['disco_total_gb'] ?? '-' ?></td>
                    <td data-label="Fecha Reporte"><?= $e['fecha_reporte'] ?></td>
                    <td data-label="Acciones" class="acciones">
                        <a class="editar" href="src/edit.php?id=<?= $e['id'] ?>">✏️ Editar</a>
                        <a class="eliminar" href="src/delete.php?id=<?= $e['id'] ?>" onclick="return confirm('¿Seguro?')">🗑️ Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>