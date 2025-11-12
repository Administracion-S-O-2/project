$(document).ready(function () {
    if (!localStorage.getItem("access_token")) {
        window.location.href = "/login.html";
        return;
    }

    function setAlert($alert, $msgEl, type, msg) {
        $alert.removeClass("d-none alert-danger alert-success")
              .addClass(type === "success" ? "alert-success" : "alert-danger");
        $msgEl.text(msg);
    }

    function loadUser() {
        $.ajax({
            url: "http://localhost:8000/api/validate/",
            type: "GET",
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("access_token")
            },
            success: function (data) {
                $("#id").val(data.id);
                $("#nombre").val(data.name);
                $("#email").val(data.email);
                $("#apellido").val(data.lastname || "");
                $("#telefono").val(data.phone || "");
                $("#bienvenido").html("Bienvenido " + data.name);
                localStorage.setItem("usuario", data.name);
            },
            error: function () {
                setAlert($("#alert-datos"), $("#alert-datos-msg"), "error", "No se pudo cargar los datos del usuario.");
            }
        });
    }

    $("#form-editar").on("submit", function (e) {
        e.preventDefault();
        $("#btn-guardar-datos").prop("disabled", true);
        const datos = {
            id: $("#id").val(),
            name: $("#nombre").val(),
            email: $("#email").val(),
            phone: $("#telefono").val(),
            lastname: $("#apellido").val()
        };
        $.ajax({
            url: "http://localhost:8000/api/editar",
            type: "POST",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("access_token")
            },
            data: JSON.stringify(datos),
            success: function () {
                setAlert($("#alert-datos"), $("#alert-datos-msg"), "success", "Datos actualizados correctamente.");
            },
            error: function (xhr) {
                const res = xhr.responseJSON;
                if (res) {
                    let errores = Object.values(res).flat().join(" ");
                    setAlert($("#alert-datos"), $("#alert-datos-msg"), "error", errores);
                } else {
                    setAlert($("#alert-datos"), $("#alert-datos-msg"), "error", "Error al actualizar los datos.");
                }
            },
            complete: function () {
                $("#btn-guardar-datos").prop("disabled", false);
            }
        });
    });

    $("#form-password").on("submit", function (e) {
        e.preventDefault();
        $("#btn-guardar-pass").prop("disabled", true);
        const current = $("#current_password").val();
        const pass = $("#password").val();
        const passConf = $("#password_confirmation").val();
        if (pass.length < 8) {
            setAlert($("#alert-pass"), $("#alert-pass-msg"), "error", "La contraseña debe tener al menos 8 caracteres.");
            $("#btn-guardar-pass").prop("disabled", false);
            return;
        }
        if (pass !== passConf) {
            setAlert($("#alert-pass"), $("#alert-pass-msg"), "error", "Las contraseñas no coinciden.");
            $("#btn-guardar-pass").prop("disabled", false);
            return;
        }
        const datos = {
            id: $("#id").val(),
            password: pass,
            password_confirmation: passConf,
            current_password: current
        };
        $.ajax({
            url: "http://localhost:8000/api/cambiarpassword",
            type: "POST",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("access_token")
            },
            data: JSON.stringify(datos),
            success: function () {
                setAlert($("#alert-pass"), $("#alert-pass-msg"), "success", "Contraseña actualizada correctamente.");
                $("#password").val("");
                $("#password_confirmation").val("");
                $("#current_password").val("");
            },
            error: function (xhr) {
                const res = xhr.responseJSON;
                if (res) {
                    let errores = Object.values(res).flat().join(" ");
                    setAlert($("#alert-pass"), $("#alert-pass-msg"), "error", errores);
                } else {
                    setAlert($("#alert-pass"), $("#alert-pass-msg"), "error", "Error al actualizar la contraseña.");
                }
            },
            complete: function () {
                $("#btn-guardar-pass").prop("disabled", false);
            }
        });
    });

    $("#cerrar-sesion").on("click", function () {
        $.ajax({
            url: "http://localhost:8000/api/logout/",
            type: "GET",
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("access_token")
            },
            success: function () {
                localStorage.removeItem("access_token");
                localStorage.removeItem("usuario");
                window.location.href = "/login.html";
            },
            error: function () {
                setAlert($("#alert-datos"), $("#alert-datos-msg"), "error", "Error al cerrar sesión.");
            }
        });
    });

    loadUser();
});
