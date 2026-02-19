<?php
/**
 * Funciones auxiliares para la API
 */

/**
 * Validar token de autenticación
 */
function validarToken() {
    header('Content-Type: application/json; charset=utf-8');
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['token'])) {
        http_response_code(400);
        echo json_encode([
            'exito' => false,
            'mensaje' => 'Token no proporcionado',
            'codigo' => 'TOKEN_FALTANTE'
        ]);
        exit;
    }
    
    if ($data['token'] !== API_TOKEN) {
        http_response_code(401);
        echo json_encode([
            'exito' => false,
            'mensaje' => 'Token inválido',
            'codigo' => 'TOKEN_INVALIDO'
        ]);
        exit;
    }
    
    return $data;
}

/**
 * Respuesta JSON exitosa
 */
function respuestaExito($mensaje, $datos = null, $codigo = 200) {
    http_response_code($codigo);
    $respuesta = [
        'exito' => true,
        'mensaje' => $mensaje
    ];
    
    if ($datos) {
        $respuesta['datos'] = $datos;
    }
    
    echo json_encode($respuesta);
    exit;
}

/**
 * Respuesta JSON con error
 */
function respuestaError($mensaje, $codigoError = 'ERROR', $codigo = 400) {
    http_response_code($codigo);
    echo json_encode([
        'exito' => false,
        'mensaje' => $mensaje,
        'codigo' => $codigoError
    ]);
    exit;
}

/**
 * Validar campos requeridos
 */
function validarCamposRequeridos($datos, $campos) {
    foreach ($campos as $campo) {
        if (!isset($datos[$campo]) || empty($datos[$campo])) {
            respuestaError("Campo requerido: $campo", 'CAMPO_FALTANTE', 400);
        }
    }
}
