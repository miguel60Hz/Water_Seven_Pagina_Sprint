(function () {
    var authSection = document.getElementById("authSection");
    var usuario = JSON.parse(localStorage.getItem("usuario"));

    if (authSection && usuario) {
        authSection.innerHTML = `
            <span class="auth-user">${usuario.nombre}</span>
            <button class="btn-outline" onclick="localStorage.removeItem('usuario');location.reload()">Cerrar sesión</button>
        `;
    }

    var toggle = document.getElementById("navToggle");
    var navbar = document.querySelector(".navbar");

    if (toggle && navbar) {
        toggle.addEventListener("click", function () {
            var abierto = navbar.classList.toggle("menu-abierto");
            toggle.setAttribute("aria-expanded", abierto ? "true" : "false");
        });

        navbar.addEventListener("click", function (e) {
            if (e.target.tagName === "A" && navbar.classList.contains("menu-abierto")) {
                navbar.classList.remove("menu-abierto");
                toggle.setAttribute("aria-expanded", "false");
            }
        });
    }
})();
