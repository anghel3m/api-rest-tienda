<?php
/**
 * API Endpoint: POST /src/create.php
 * Inserta un nuevo equipo o actualiza si serial_bios ya existe
 * Usa: INSERT ... ON DUPLICATE KEY UPDATE
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/api_helpers.php';

// Verificar que sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respuestaError('Solo acepta método POST', 'METODO_NO_PERMITIDO', 405);
}

// Validar token
$datos = validarToken();

// Campos requeridos para crear/actualizar
$camposRequeridos = ['serial_bios', 'nombre_equipo', 'fecha_reporte'];
validarCamposRequeridos($datos, $camposRequeridos);

try {
    // Preparar datos - usar null para campos vacíos
    $datos_equipo = [
        'nombre_responsable' => $datos['nombre_responsable'] ?? null,
        'id_responsable' => $datos['id_responsable'] ?? null,
        'nombre_equipo' => $datos['nombre_equipo'],
        'usuario' => $datos['usuario'] ?? null,
        'sistema_operativo' => $datos['sistema_operativo'] ?? null,
        'version_windows' => $datos['version_windows'] ?? null,
        'modelo' => $datos['modelo'] ?? null,
        'marca' => $datos['marca'] ?? null,
        'serial_bios' => $datos['serial_bios'],
        'uuid_equipo' => $datos['uuid_equipo'] ?? null,
        'procesador' => $datos['procesador'] ?? null,
        'nucleos' => $datos['nucleos'] ?? null,
        'ram_total_gb' => $datos['ram_total_gb'] ?? null,
        'disco_total_gb' => $datos['disco_total_gb'] ?? null,
        'tipo_disco' => $datos['tipo_disco'] ?? null,
        'fecha_reporte' => $datos['fecha_reporte'],
        'ultimo_arranque' => $datos['ultimo_arranque'] ?? null
    ];

    // SQL con INSERT ... ON DUPLICATE KEY UPDATE
    $sql = "INSERT INTO equipos 
    (nombre_responsable, id_responsable, nombre_equipo, usuario, 
     sistema_operativo, version_windows, modelo, marca, 
     serial_bios, uuid_equipo, procesador, nucleos, 
     ram_total_gb, disco_total_gb, tipo_disco, fecha_reporte, ultimo_arranque) 
    VALUES 
    (:nombre_responsable, :id_responsable, :nombre_equipo, :usuario,
     :sistema_operativo, :version_windows, :modelo, :marca,
     :serial_bios, :uuid_equipo, :procesador, :nucleos,
     :ram_total_gb, :disco_total_gb, :tipo_disco, :fecha_reporte, :ultimo_arranque)
    ON DUPLICATE KEY UPDATE
    nombre_responsable = VALUES(nombre_responsable),
    id_responsable = VALUES(id_responsable),
    nombre_equipo = VALUES(nombre_equipo),
    usuario = VALUES(usuario),
    sistema_operativo = VALUES(sistema_operativo),
    version_windows = VALUES(version_windows),
    modelo = VALUES(modelo),
    marca = VALUES(marca),
    uuid_equipo = VALUES(uuid_equipo),
    procesador = VALUES(procesador),
    nucleos = VALUES(nucleos),
    ram_total_gb = VALUES(ram_total_gb),
    disco_total_gb = VALUES(disco_total_gb),
    tipo_disco = VALUES(tipo_disco),
    fecha_reporte = VALUES(fecha_reporte),
    ultimo_arranque = VALUES(ultimo_arranque)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($datos_equipo);

    $accion = $stmt->rowCount() > 1 ? 'actualizado' : 'insertado';

    respuestaExito(
        "Equipo $accion correctamente",
        [
            'serial_bios' => $datos['serial_bios'],
            'accion' => $accion
        ],
        201
    );

} catch (Exception $e) {
    respuestaError(
        'Error al procesar el equipo: ' . $e->getMessage(),
        'ERROR_BD',
        500
    );
}
