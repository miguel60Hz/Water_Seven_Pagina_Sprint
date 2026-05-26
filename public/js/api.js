const API = '../app/controllers';

const api = {

    async login(correo, password) {
        const res = await fetch(`${API}/AuthController.php?accion=login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ correo, password })
        });
        return await res.json();
    },

    async registro(nombre, correo, password) {
        const res = await fetch(`${API}/AuthController.php?accion=registro`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre, correo, password })
        });
        return await res.json();
    },

    async obtenerPublicaciones() {
        const res = await fetch(`${API}/PublicacionController.php?accion=listar`);
        return await res.json();
    },

    async crearPublicacion(usuario_id, contenido, tipo) {
        const res = await fetch(`${API}/PublicacionController.php?accion=crear`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ usuario_id, contenido, tipo })
        });
        return await res.json();
    },

    async crearComentario(publicacion_id, usuario_id, contenido) {
        const res = await fetch(`${API}/ComentarioController.php?accion=crear`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ publicacion_id, usuario_id, contenido })
        });
        return await res.json();
    },

    async obtenerMensajes() {
        const res = await fetch(`${API}/MensajeController.php?accion=listar`);
        return await res.json();
    },

    async enviarMensaje(remitente_id, contenido) {
        const res = await fetch(`${API}/MensajeController.php?accion=crear`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ remitente_id, contenido })
        });
        return await res.json();
    }
};
