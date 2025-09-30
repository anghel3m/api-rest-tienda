<?php
require_once "../config/database.php";

if ($_POST) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $active = isset($_POST['active']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE productos SET nombre = :nombre, precio = :precio, active = :active WHERE id = :id");
    $stmt->execute([
        'nombre' => $nombre,
        'precio' => $precio,
        'active' => $active,
        'id' => $id
    ]);

    header("Location: ../index.php");
    exit;
}
