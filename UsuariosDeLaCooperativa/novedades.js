$(document).ready(function () {
    const novedades = [
        {
            titulo: "Conoce como tu ayuda hace la diferencia",
            texto: "Descubre las historias inspiradoras de personas que han mejorado su calidad de vida gracias a tu apoyo y colaboración.",
            imagen: "img/login/manos.jpg"
        },
        {
            titulo: "Actualización del sistema",
            texto: "Se mejoró la seguridad del sistema y se optimizó el rendimiento de la base de datos para una experiencia más fluida.",
            imagen: "img/news/database.png"
        },
        {
            titulo: "Curso de capacitación para socios",
            texto: "Invitamos a todos los socios a participar en nuestro próximo curso de capacitación sobre gestión financiera y administración cooperativa.",
            imagen: "img/news/reunion.jpg"
        },
        {
            titulo: "Nuevo canal de soporte",
            texto: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. lorem ipsum dolor sit amet, consectetur adipiscing elit. lorem ipsum dolor sit amet, consectetur adipiscing elit. lorem ipsum dolor sit amet, consectetur adipiscing elit. lorem ipsum dolor sit amet, consectetur adipiscing elit. lorem ipsum dolor sit amet, consectetur adipiscing elit. lorem ipsum dolor sit amet, consectetur adipiscing elit. lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            imagen: "img/news/technician.jpg"
        }
    ];

    let contenedor = $("#contenedor-novedades");
    novedades.forEach(n => {
        let card = `
            <div class="noticia">
                <img src="${n.imagen}" alt="${n.titulo}">
                <div class="contenido">
                    <h5>${n.titulo}</h5>
                    <p>${n.texto}</p>
                </div>
            </div>
        `;
        contenedor.append(card);
    });
});
