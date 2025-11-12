$(document).ready(function () {

    getWorkedHours();

    function getWorkedHours(){
        let data = localStorage.getItem("access_token");

        $.ajax({
            url: "http://localhost:8001/work-hours",
            type: "GET",
            header: {
                "Authorization": "Bearer " + data 
            },
            data: JSON.stringify(data),
            success: function (data) {
                mostrarHoras(data);
                contadorDeHoras(data);
            },
            error: function (xhr) {
                alert(xhr.error);
                console.error(xhr.responseText);
            }
        });
    }

    function mostrarHoras(horas){
        let html = ``;
        horas.forEach(hora => {
            html += `
            <tr>
                <td>${hora.created_at}</td>
                <td>${hora.hours}</td>
            </tr>
            `
        });
        document.getElementById('myHours').innerHTML = html;
    }

    function contadorDeHoras(horas){
        let cantHoras = 0;
        horas.forEach(hora => {
            cantHoras += hora.hours;
        });
        document.getElementById('cantHoras').innerHTML = cantHoras;
    }

});