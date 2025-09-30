<?php
require_once "../config/database.php";

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: ../public/index.php");
exit;
