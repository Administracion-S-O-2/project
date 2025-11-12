window.addEventListener("load", inicio);

function inicio() {

}

function solicitarRegistro(event) {
    event.preventDefault(); 
    fetch("http://localhost:8001/api/noAprobado", {
        method: "POST",
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "name": event.target.nombre.value,
            "email": event.target.email.value,
            "password": event.target.password.value,
            "password_confirmation": event.target.password_confirmation.value,
            "lastname": event.target.apellido.value
        })
    })
    .then(response => {
        response.json().then(datos => {
            if(response.ok){
                mensajeExito(datos.message);
            } else {
                mensajeError(datos.error || datos.message);
            }
        });
    })
}

function mensajeExito(mensaje){
    Swal.fire({
        text: `${mensaje}`,
        icon: "success"
    });
}

function mensajeError(mensaje){
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: `${mensaje}`
    });
}