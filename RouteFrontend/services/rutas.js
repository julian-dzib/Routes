const RUTAS_API_URL = "http://127.0.0.1:8000/api/routes";

// GET: Listar rutas
async function getRoutes() {
    try {
        const response = await fetch(RUTAS_API_URL);
        if (!response.ok) throw new Error(`Status: ${response.status}`);
        const result = await response.json();
        renderRoutes(result.data);
    } catch (error) {
        alert(error.message);
    }
}

function renderRoutes(data) {
    const container = document.getElementById("route-container");
    if (!container) return;
    let html = `
        <h2>Listar Rutas</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>FECHA</th>
                    <th>NOMBRE DEL CHOFER</th>
                </tr>
            </thead>
            <tbody>
    `;
    data.forEach(item => {
        html += `
            <tr>
                <td>${item.NOMBRE}</td>
                <td>${new Date(item.FECHA).toLocaleDateString()}</td>
                <td>${item.chofer ? item.chofer.NOMBRE : 'No se ha asignando ningun chofer'}</td>
            </tr>
        `;
    });
    html += `
            </tbody>
        </table>
    `;
    container.innerHTML = html;
}

// Mostrar rutas al cargar
window.addEventListener('DOMContentLoaded', getRoutes);