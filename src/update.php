<?php
/**
 * API Endpoint: PUT /src/update.php
 * Actualiza un equipo existente por su serial_bios o id
 * (Nota: create.php maneja ambos inserts y updates con ON DUPLICATE KEY)
 * Este endpoint es para actualizar campos específicos
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/api_helpers.php';

// Verificar que sea PUT o POST con _method=PUT
$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'PUT' && !($method === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT')) {
    respuestaError('Solo acepta método PUT', 'METODO_NO_PERMITIDO', 405);
}

// Validar token
$datos = validarToken();

// Requiere serial_bios o id
if (!isset($datos['serial_bios']) && !isset($datos['id'])) {
    respuestaError('Debe proporcionar serial_bios o id', 'PARAMETRO_FALTANTE', 400);
}

try {
    // Determinar qué usar para identificar el equipo
    if (isset($datos['serial_bios'])) {
        $identificador = 'serial_bios';
        $valor = $datos['serial_bios'];
        
        // Verificar que exista primero
        $check = $pdo->prepare("SELECT id FROM equipos WHERE serial_bios = :serial_bios");
        $check->execute(['serial_bios' => $valor]);
        if (!$check->fetch()) {
            respuestaError("Equipo no encontrado con $identificador: $valor", 'NO_ENCONTRADO', 404);
        }
    } else {
        $identificador = 'id';
        $valor = $datos['id'];
        
        // Verificar que exista primero
        $check = $pdo->prepare("SELECT id FROM equipos WHERE id = :id");
        $check->execute(['id' => $valor]);
        if (!$check->fetch()) {
            respuestaError("Equipo no encontrado con $identificador: $valor", 'NO_ENCONTRADO', 404);
        }
    }

    // Campos que se pueden actualizar (todos menos serial_bios y timestamps)
    $camposActualizables = [
        'nombre_responsable', 'id_responsable', 'nombre_equipo', 'usuario',
        'sistema_operativo', 'version_windows', 'modelo', 'marca',
        'uuid_equipo', 'procesador', 'nucleos', 'ram_total_gb',
        'disco_total_gb', 'tipo_disco', 'fecha_reporte', 'ultimo_arranque'
    ];

    // Construir partes UPDATE dinámicamente
    $setClausu = [];
    $parametros = [];
    
    foreach ($camposActualizables as $campo) {
        if (isset($datos[$campo])) {
            $setClausu[] = "$campo = :$campo";
            $parametros[$campo] = $datos[$campo];
        }
    }

    if (empty($setClausu)) {
        respuestaError('No hay campos para actualizar', 'SIN_DATOS', 400);
    }

    // Preparar query
    if ($identificador === 'serial_bios') {
        $sql = "UPDATE equipos SET " . implode(', ', $setClausu) . " WHERE serial_bios = :serial_bios";
        $parametros['serial_bios'] = $valor;
    } else {
        $sql = "UPDATE equipos SET " . implode(', ', $setClausu) . " WHERE id = :id";
        $parametros['id'] = $valor;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($parametros);

    respuestaExito(
        "Equipo actualizado correctamente",
        [
            'identificador' => $identificador,
            'valor' => $valor,
            'campos_actualizados' => count($setClausu)
        ]
    );

} catch (Exception $e) {
    respuestaError(
        'Error al actualizar el equipo: ' . $e->getMessage(),
        'ERROR_BD',
        500
    );
