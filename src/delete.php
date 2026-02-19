<?php
/**
 * API Endpoint: DELETE /src/delete.php
 * Elimina un equipo por su serial_bios o id
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/api_helpers.php';

// Verificar que sea DELETE o POST con _method=DELETE
$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'DELETE' && !($method === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE')) {
    respuestaError('Solo acepta método DELETE', 'METODO_NO_PERMITIDO', 405);
}

// Validar token
$datos = validarToken();

// Requiere serial_bios o id
if (!isset($datos['serial_bios']) && !isset($datos['id'])) {
    respuestaError('Debe proporcionar serial_bios o id', 'PARAMETRO_FALTANTE', 400);
}

try {
    // Se puede eliminar por serial_bios o por id
    if (isset($datos['serial_bios'])) {
        $stmt = $pdo->prepare("DELETE FROM equipos WHERE serial_bios = :serial_bios");
        $stmt->execute(['serial_bios' => $datos['serial_bios']]);
        $identificador = $datos['serial_bios'];
        $tipo = 'serial_bios';
    } else {
        $stmt = $pdo->prepare("DELETE FROM equipos WHERE id = :id");
        $stmt->execute(['id' => $datos['id']]);
        $identificador = $datos['id'];
        $tipo = 'id';
    }

    if ($stmt->rowCount() === 0) {
        respuestaError("Equipo no encontrado con $tipo: $identificador", 'NO_ENCONTRADO', 404);
    }

    respuestaExito(
        "Equipo eliminado correctamente",
        [
            'tipo' => $tipo,
            'valor' => $identificador
        ]
    );

} catch (Exception $e) {
    respuestaError(
        'Error al eliminar el equipo: ' . $e->getMessage(),
        'ERROR_BD',
        500
    );
}
