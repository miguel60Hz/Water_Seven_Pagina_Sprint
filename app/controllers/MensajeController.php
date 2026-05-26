<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Mensaje.php';

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
if (!$accion) {
    echo json_encode(['error' => 'Acción no especificada']);
    exit;
}

if ($accion === 'listar') {
    echo json_encode(todosLosMensajes());
    exit;
}

if ($accion === 'crear') {
    $datos = json_decode(file_get_contents('php://input'), true);

    if (!$datos || empty($datos['remitente_id']) || empty($datos['contenido'])) {
        echo json_encode(['error' => 'Datos incompletos']);
        exit;
    }

    $id = crearMensaje($datos['remitente_id'], $datos['contenido']);
    echo json_encode(['success' => true, 'id' => $id]);
    exit;
}

echo json_encode(['error' => 'Acción no válida']);
