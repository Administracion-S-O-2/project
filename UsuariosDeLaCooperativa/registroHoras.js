$(document).ready(function () {
    function mostrarExito(msg) {
        $("#success-msg").text(msg);
        $("#success").removeClass("d-none");
        $("#error").addClass("d-none");
    }

    function mostrarError(msg) {
        $("#error-msg").text(msg);
        $("#error").removeClass("d-none");
    }

    function ocultarError() {
        $("#error").addClass("d-none");
    }

    $("#registroHorasForm").submit(function(e) {
        e.preventDefault();
        ocultarError();
        $("#success").addClass("d-none");

        var data = {
            date: $("#fecha").val(),
            hours: parseInt($("#horas").val())
        };

        $.ajax({
            url: "http://localhost:8001/api/work-hours",
            type: "POST",
            contentType: "application/json",
            headers: { 
                "Accept": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("access_token") 
            },
            data: JSON.stringify(data),
            success: function(res) {
                mostrarExito(res.message || "Horas registradas correctamente");
                $("#registroHorasForm")[0].reset();
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mostrarError(xhr.responseJSON.message);
                } else {
                    mostrarError("Error al registrar horas");
                }
            }
        });
    });
});
