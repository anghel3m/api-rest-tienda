<?php

$conn = require __DIR__ . '/../config/database.php';

$sql = "SELECT id, nombre, precio, active, created_at, updated_at FROM productos";
$stmt = $conn->query($sql);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($productos);
