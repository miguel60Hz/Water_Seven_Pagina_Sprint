<?php
function todasLasPublicaciones() {
    $pdo = conectarBD();
    return $pdo->query("SELECT p.id, p.contenido, p.tipo, p.fecha_publicacion,
                               u.nombre_completo AS usuario_nombre
                        FROM publicaciones p
                        JOIN usuarios u ON u.id = p.usuario_id
                        WHERE p.activa = 1
                        ORDER BY p.fecha_publicacion DESC
                        LIMIT 50")->fetchAll();
}

function crearPublicacion($usuario_id, $contenido, $tipo) {
    $pdo = conectarBD();
    $pdo->prepare("INSERT INTO publicaciones (usuario_id, contenido, tipo) VALUES (?, ?, ?)")
        ->execute([$usuario_id, $contenido, $tipo]);
    return $pdo->lastInsertId();
}
