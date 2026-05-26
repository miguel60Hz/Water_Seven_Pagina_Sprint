<?php
function todosLosMensajes() {
    $pdo = conectarBD();
    return $pdo->query("SELECT m.id, m.contenido, m.fecha_envio,
                               u.nombre_completo AS remitente_nombre
                        FROM mensajes_chat m
                        JOIN usuarios u ON u.id = m.remitente_id
                        ORDER BY m.fecha_envio ASC")->fetchAll();
}

function crearMensaje($remitente_id, $contenido) {
    $pdo = conectarBD();
    $pdo->prepare("INSERT INTO mensajes_chat (remitente_id, contenido) VALUES (?, ?)")
        ->execute([$remitente_id, $contenido]);
    return $pdo->lastInsertId();
}
