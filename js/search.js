   
function buscarProducto() {
    const input = document.getElementById("busqueda").value.toLowerCase();
    const filas = document.querySelectorAll("#tabla-productos tr");

    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(input) ? "" : "none";
    });
}
