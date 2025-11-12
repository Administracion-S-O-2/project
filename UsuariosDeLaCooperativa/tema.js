$(document).ready(function () {
    const switchOscuro = $("#modoOscuroSwitch");

    function aplicarTema(modoOscuro) {
        if (modoOscuro) {
            $("html").addClass("modo-oscuro");
            localStorage.setItem("modoOscuro", "true");
        } else {
            $("html").removeClass("modo-oscuro");
            localStorage.setItem("modoOscuro", "false");
        }
    }

    const modoGuardado = localStorage.getItem("modoOscuro") === "true";
    aplicarTema(modoGuardado);

    if (switchOscuro.length) {
        switchOscuro.prop("checked", modoGuardado);
        switchOscuro.on("change", function () {
            aplicarTema($(this).is(":checked"));
        });
    }
});
