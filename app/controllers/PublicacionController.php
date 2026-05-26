<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Publicacion.php';
require_once __DIR__ . '/../models/Comentario.php';

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
if (!$accion) {
    echo json_encode(['error' => 'Acción no especificada']);
    exit;
}

if ($accion === 'listar') {
    $publicaciones = todasLasPublicaciones();

    foreach ($publicaciones as &$pub) {
        $pub['comentarios'] = comentariosDePublicacion($pub['id']);
    }

    echo json_encode($publicaciones);
    exit;
}

if ($accion === 'crear') {
    $datos = json_decode(file_get_contents('php://input'), true);

    if (!$datos || empty($datos['usuario_id']) || empty($datos['contenido'])) {
        echo json_encode(['error' => 'Datos incompletos']);
        exit;
    }

    $id = crearPublicacion($datos['usuario_id'], $datos['contenido'], $datos['tipo'] ?? 'general');
    echo json_encode(['success' => true, 'id' => $id]);
    exit;
}

echo json_encode(['error' => 'Acción no válida']);
