<?php
function comentariosDePublicacion($publicacion_id) {
    $pdo = conectarBD();
    $stmt = $pdo->prepare("SELECT c.contenido, c.fecha_comentario,
                                  u.nombre_completo AS usuario_nombre
                           FROM comentarios c
                           JOIN usuarios u ON u.id = c.usuario_id
                           WHERE c.publicacion_id = ?
                           ORDER BY c.fecha_comentario ASC");
    $stmt->execute([$publicacion_id]);
    return $stmt->fetchAll();
}

function crearComentario($publicacion_id, $usuario_id, $contenido) {
    $pdo = conectarBD();
    $pdo->prepare("INSERT INTO comentarios (publicacion_id, usuario_id, contenido) VALUES (?, ?, ?)")
        ->execute([$publicacion_id, $usuario_id, $contenido]);
    return $pdo->lastInsertId();
}
