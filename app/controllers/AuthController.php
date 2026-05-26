<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

if (!$accion) {
    echo json_encode(['error' => 'Acción no especificada']);
    exit;
}

$datos = json_decode(file_get_contents('php://input'), true);

if (!$datos) {
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

if ($accion === 'login') {
    if (empty($datos['correo']) || empty($datos['password'])) {
        echo json_encode(['error' => 'Completa todos los campos']);
        exit;
    }

    $usuario = usuarioPorCorreo($datos['correo']);

    if (!$usuario || !password_verify($datos['password'], $usuario['contrasena_hash'])) {
        echo json_encode(['error' => 'Correo o contraseña incorrectos']);
        exit;
    }

    actualizarAcceso($usuario['id']);

    echo json_encode([
        'success' => true,
        'usuario' => [
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre_completo'],
            'correo' => $usuario['correo']
        ]
    ]);
    exit;
}

if ($accion === 'registro') {
    if (empty($datos['nombre']) || empty($datos['correo']) || empty($datos['password'])) {
        echo json_encode(['error' => 'Completa todos los campos']);
        exit;
    }

    if (existeCorreo($datos['correo'])) {
        echo json_encode(['error' => 'El correo ya está registrado']);
        exit;
    }

    $hash = password_hash($datos['password'], PASSWORD_BCRYPT);
    crearUsuario($datos['nombre'], $datos['correo'], $hash);

    echo json_encode(['success' => true, 'mensaje' => 'Registro exitoso']);
    exit;
}

echo json_encode(['error' => 'Acción no válida']);
