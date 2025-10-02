<?php
header("Content-Type: application/json; charset=UTF-8");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = explode("/", trim($_SERVER["REQUEST_URI"], "/"));

// Detectar recurso
$resource = $requestUri[1] ?? null; // ejemplo: /api.php/productos
$id = $requestUri[2] ?? null;

switch ($resource) {
    case "productos":
        require __DIR__ . "/src/productos.php";
        handleProductos($requestMethod, $id);
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Recurso no encontrado"]);
        break;
}
