<?php
function usuarioPorCorreo($correo) {
    $pdo = conectarBD();
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ? AND activo = 1");
    $stmt->execute([$correo]);
    return $stmt->fetch();
}

function existeCorreo($correo) {
    $pdo = conectarBD();
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    return $stmt->fetch() ? true : false;
}

function crearUsuario($nombre, $correo, $hash) {
    $pdo = conectarBD();
    $pdo->prepare("INSERT INTO usuarios (nombre_completo, correo, contrasena_hash) VALUES (?, ?, ?)")
        ->execute([$nombre, $correo, $hash]);
    return $pdo->lastInsertId();
}

function actualizarAcceso($id) {
    $pdo = conectarBD();
    $pdo->prepare("UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = ?")->execute([$id]);
}
