$(document).ready(function () {

    $.ajax({
        url: "http://localhost:8001/api/unidades",
        type: "GET",
        contentType: "application/json",
        headers: { 
            "Accept": "application/json",
            "Authorization": "Bearer " + localStorage.getItem("access_token") 
        },
        success: function(respuesta) {
            console.log(respuesta);
            mostrarObras(respuesta[0]);
        },
        error: function(xhr) {
            alert("error")
        }
    });

    function mostrarObras(obras){
        let articles = ``;
        for (let i = 0; i < obras.length; i++) {
            articles +=
            `
                <article class="col-12 col-md-10 col-lg-5 card p-4 bg-success text-light d-flex flex-col gap-2">
                    <h2 class="fs-4">${obras[i].street} ${obras[i].door}</h2>
                    <h3 class="fs-5"><em> ${obras[i].etapa.name} </em></h3>
                    <p class="rounded-3 p-2 bg-success-subtle text-success-emphasis"> ${obras[i].etapa.description}</p>
                </article>
            `;
        }
        document.getElementById('estadoDeObras').innerHTML = articles;

    }
});
