CREATE DATABASE IF NOT EXISTS water_seven
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE water_seven;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(120) NOT NULL,
    correo VARCHAR(120) NOT NULL UNIQUE,
    contrasena_hash VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL DEFAULT 2,
    telefono VARCHAR(20),
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso DATETIME,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);

CREATE INDEX idx_usuarios_correo ON usuarios(correo);

INSERT INTO roles (nombre, descripcion) VALUES
    ('admin', 'Administrador del sistema con permisos totales'),
    ('usuario', 'Usuario estándar que puede reportar y ver fuentes'),
    ('moderador', 'Moderador de la comunidad');

CREATE TABLE publicaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    contenido TEXT NOT NULL,
    tipo ENUM('reporte', 'alerta', 'general', 'consejo') NOT NULL DEFAULT 'general',
    fecha_publicacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    activa TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE INDEX idx_publicaciones_fecha ON publicaciones(fecha_publicacion);

CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    publicacion_id INT NOT NULL,
    usuario_id INT NOT NULL,
    contenido TEXT NOT NULL,
    fecha_comentario DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (publicacion_id) REFERENCES publicaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE mensajes_chat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    remitente_id INT NOT NULL,
    contenido TEXT NOT NULL,
    leido TINYINT(1) NOT NULL DEFAULT 0,
    fecha_envio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (remitente_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE INDEX idx_mensajes_fecha ON mensajes_chat(fecha_envio);
