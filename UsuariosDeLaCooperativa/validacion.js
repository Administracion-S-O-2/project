$(document).ready(function () {
    function obtenerNombreDeUsuario() {
        $.ajax({
            url: 'http://localhost:8000/api/validate',
            type: 'GET',
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("access_token")
            },
            success: function (data) {
                const nombre = data.name || data.username || "";
                const apellido = data.last_name || data.lastname || data.apellido || (data.user ? data.user.last_name : "") || "";

                localStorage.setItem("usuario", nombre);
                if (apellido) {
                    localStorage.setItem("last_name", apellido);
                    $("#bienvenido").html("Hola! " + nombre + " " + apellido);
                } else {
                    localStorage.removeItem("last_name");
                    $("#bienvenido").html("Hola! " + nombre);
                }
            },
            error: function () {
                mostrarError("Error al validar la sesión. Redirigiendo...");
                setTimeout(() => {
                    localStorage.removeItem("access_token");
                    localStorage.removeItem("usuario");
                    window.location.href = "login.html";
                }, 2000);
            }
        });
    }

    if (!localStorage.getItem("access_token")) {
        mostrarError("No tienes una sesión activa. Redirigiendo...");
        setTimeout(() => {
            window.location.href = "login.html";
        }, 2000);
        return;
    }

    obtenerNombreDeUsuario();

    $("#cerrar-sesion").click(function () {
        $.ajax({
            url: 'http://localhost:8000/api/logout',
            type: 'POST',
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("access_token")
            },
            success: function () {
                localStorage.clear();
                window.location.href = "login.html";
            },
            error: function () {
                mostrarError("Error al cerrar sesión");
            }
        });
    });
});

function mostrarError(mensaje) {
    $("#error-msg").text(mensaje);
    $("#error").removeClass("d-none");
}

function ocultarError() {
    $("#error").addClass("d-none");
}
