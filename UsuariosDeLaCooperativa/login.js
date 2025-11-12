$(document).ready(function () {
    let currentIndex = 0;
    const images = $(".carousel-image");
    const total = images.length;

    setInterval(() => {
        images.eq(currentIndex).removeClass("active");
        currentIndex = (currentIndex + 1) % total;
        images.eq(currentIndex).addClass("active");
    }, 5000);

    $("#boton").click(function () {
        let usuario = $("#usuario").val().trim();
        let password = $("#password").val().trim();

        if (usuario === "" || password === "") {
            mostrarError("Debes completar todos los campos.");
            return;
        }

        var data = {
            "username": usuario,
            "password": password,
            "grant_type": "password",
            "client_id": "2",
            "client_secret": "ElEP1LeengsUgpcPOdhSYuP6KQN2zdf49Npp2B2Q"
        };

        $.ajax({
            url: "http://localhost:8000/oauth/token",
            type: "POST",
            data: data,
            success: function (data) {
                localStorage.setItem("access_token", data.access_token);
                ocultarError();
                window.location.href = "./index.html";
            },
            error: function (xhr) {
                mostrarError("Usuario no encontrado o credenciales incorrectas.");
                console.error(xhr.responseText);
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
