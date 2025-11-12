$(document).ready(function () {

    if (!localStorage.getItem("access_token")) {
        alert("No tienes sesión activa. Redirigiendo...");
        window.location.href = "/login.html"; 
        return;
    }

    $("#form-comprobante").submit(function (e) {
        e.preventDefault();

        const tipoSeleccionado = document.querySelector('input[name="tipo"]:checked');
        if (!tipoSeleccionado) {
            document.getElementById("error-msg").innerHTML = "Por favor selecciona un tipo de comprobante";
            return;
        }

        const formData = new FormData(this);

        fetch("http://localhost:8001/api/comprobantes", {
            method: "POST",
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("access_token")
            },
            body: formData
        })
        .then(response => response.json())
        .then(datos => {
            if (response.ok) {
                document.getElementById("form-comprobante").reset();
                document.getElementById("success").innerHTML = datos.message;
                document.getElementById("success").classList.remove("d-none");
            } else {
                document.getElementById("error-msg").innerHTML = datos.error || datos.message;
            }
        })
        .catch(err => {
            document.getElementById("error-msg").innerHTML = "Error al conectar con el servidor.";
            console.error(err);
        });
    });
});
