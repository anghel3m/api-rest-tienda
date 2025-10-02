<?php
function handleProductos($method, $id = null) {
    switch ($method) {
        case "GET":
            if ($id) {
                echo json_encode(["id" => $id, "nombre" => "Producto $id", "precio" => 100]);
            } else {
                echo json_encode([
                    ["id" => 1, "nombre" => "Producto 1", "precio" => 50],
                    ["id" => 2, "nombre" => "Producto 2", "precio" => 150]
                ]);
            }
            break;

        case "POST":
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode(["message" => "Producto creado", "producto" => $data]);
            break;

        case "PUT":
            if ($id) {
                $data = json_decode(file_get_contents("php://input"), true);
                echo json_encode(["message" => "Producto $id actualizado", "nuevo" => $data]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Falta ID"]);
            }
            break;

        case "DELETE":
            if ($id) {
                echo json_encode(["message" => "Producto $id eliminado"]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Falta ID"]);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
            break;
    }
}
