<?php
require_once "../config/database.php";

if ($_POST) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio) VALUES (:nombre, :precio)");
    $stmt->execute(['nombre' => $nombre, 'precio' => $precio]);

    header("Location: ../index.php");
    exit;
}
