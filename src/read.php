<?php
/**
 * API Endpoint: GET /src/read.php
 * Recupera todos los equipos o un equipo específico
 * Parámetros opcionales: serial_bios, id, nombre_equipo
 * Requiere token en GET: ?token=tu_token
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/api_helpers.php';

// Verificar que sea GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    respuestaError('Solo acepta método GET', 'METODO_NO_PERMITIDO', 405);
}

// Validar token desde query string
if (!isset($_GET['token'])) {
    respuestaError('Token no proporcionado', 'TOKEN_FALTANTE', 400);
}

if ($_GET['token'] !== API_TOKEN) {
    respuestaError('Token inválido', 'TOKEN_INVALIDO', 401);
}

try {
    $sql = "SELECT * FROM equipos";
    $parametros = [];

    // Filtros opcionales
    if (isset($_GET['serial_bios'])) {
        $sql .= " WHERE serial_bios = :serial_bios";
        $parametros['serial_bios'] = $_GET['serial_bios'];
    } 
    elseif (isset($_GET['id'])) {
        $sql .= " WHERE id = :id";
        $parametros['id'] = $_GET['id'];
    }
    elseif (isset($_GET['nombre_equipo'])) {
        $sql .= " WHERE nombre_equipo LIKE :nombre_equipo";
        $parametros['nombre_equipo'] = '%' . $_GET['nombre_equipo'] . '%';
    }

    $sql .= " ORDER BY updated_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($parametros);

    $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    respuestaExito(
        "Equipos recuperados correctamente",
        [
            'total' => count($equipos),
            'equipos' => $equipos
        ],
        200
    );

} catch (Exception $e) {
    respuestaError(
        'Error al recuperar equipos: ' . $e->getMessage(),
        'ERROR_BD',
        500
    );
}
