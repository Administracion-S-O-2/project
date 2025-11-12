$(document).ready(function () { 
   $("#cerrar-sesion-navbar-sm").on("click", function () {
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
                window.location.href = "login.html";
            },
            error: function () {
                setAlert($("#alert-datos"), $("#alert-datos-msg"), "error", "Error al cerrar sesión.");
            }
        });
    });
       $("#cerrar-sesion-navbar-lg").on("click", function () {
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
                window.location.href = "login.html";
            },
            error: function () {
                setAlert($("#alert-datos"), $("#alert-datos-msg"), "error", "Error al cerrar sesión.");
            }
        });
    });
});
