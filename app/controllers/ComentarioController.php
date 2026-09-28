<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Comentario.php';

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
if (!$accion) {
    echo json_encode(['error' => 'Acción no especificada']);
    exit;
}

if ($accion !== 'crear') {
    echo json_encode(['error' => 'Acción no válida']);
    exit;
}

$datos = json_decode(file_get_contents('php://input'), true);

if (!$datos || !isset($datos['publicacion_id'], $datos['usuario_id'], $datos['contenido'])) {
    echo json_encode(['error' => 'Datos incompletos']);
    exit;
}

$id = crearComentario($datos['publicacion_id'], $datos['usuario_id'], $datos['contenido']);
echo json_encode(['success' => true, 'id' => $id]);
