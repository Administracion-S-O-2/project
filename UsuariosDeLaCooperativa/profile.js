$(document).ready(function () {

    loadUser();

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
            },
            error: function () {
                setAlert($("#alert-datos"), $("#alert-datos-msg"), "error", "No se pudo cargar los datos del usuario.");
            }
        });
    }
    
});