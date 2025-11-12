(function() {
    try {
        const modoOscuro = localStorage.getItem("modoOscuro") === "true";
        if (modoOscuro) {
            document.documentElement.classList.add("modo-oscuro");
        }
    } catch (e) {}
})();
