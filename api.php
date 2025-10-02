<?php
require __DIR__ . '/config/database.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));

$resource = $request[0] ?? null;
$id = $request[1] ?? null;

if ($resource === "productos") {
    switch ($method) {
        case 'GET':
            require __DIR__ . '/src/productos.php';
            break;
        default:
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Recurso no encontrado"]);
}
