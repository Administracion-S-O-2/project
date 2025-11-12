$(document).ready(function () {

    getComprobantes();

    function getComprobantes(){
        let data = localStorage.getItem("access_token");

        $.ajax({
            url: "http://localhost:8001/comprobantes",
            type: "GET",
            header: {
                "Authorization": "Bearer " + data 
            },
            data: JSON.stringify(data),
            success: function (data) {
                mostrarComprobantes(data);
            },
            error: function (xhr) {
                alert(xhr.error);
                console.error(xhr.responseText);
            }
        });
    }

    function mostrarComprobantes(comprobantes){
        let html = ``;
        comprobantes.forEach(comprobante => {
            html += `
            <tr>
                <td>${comprobante.created_at}</td>
                <td>${comprobante.totalAmount}</td>
                <td>${comprobante.totalHours}</td>
                <td>${comprobante.type}</td>
                ${estadoComprobante(comprobante.state)}
            </tr>
            `
        });
        document.getElementById('myComprobantes').innerHTML = html;
    }

    function estadoComprobante(estado){
        let retorno = ``;
        switch(estado) {
            case "Pending":
                retorno = `<td class="text-warning">Pendiente</td>`
                break;
            case "Accepted":
                retorno = `<td class="text-success">Aprobado</td>`
                break;
            case "Refused":
                retorno =`<td class="text-danger">Rechazado</td>`
                break;
        }
        return retorno;
    }

});