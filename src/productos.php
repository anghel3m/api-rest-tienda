<?php
// Conexión
$conn = require __DIR__ . '/../config/database.php';

// Consulta
$sql = "SELECT id, nombre, precio, active, created_at, updated_at FROM productos";
$stmt = $conn->query($sql);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver como JSON
echo json_encode($productos);
