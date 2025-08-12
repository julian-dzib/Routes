const PUNTOS_API_URL = "http://127.0.0.1:8000/api/stops";
// GET: Listar puntos de entrega
async function getPuntos() {
    try {
        const response = await fetch(PUNTOS_API_URL);
        if (!response.ok) throw new Error(`Status: ${response.status}`);
        const result = await response.json();
        renderPuntos(result.data);
    } catch (error) {
        alert(error.message);
    }
}

//Renderizar para mostrar los puntos de entrega
function renderPuntos(data) {
    const container = document.getElementById("puntos-container");
    if (!container) return;
    let html = `
        <h2>Puntos de Entrega</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Dirección</th>
                    <th>Orden</th>
                    <th>Entregado</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
    `;
    data.forEach((item, idd) => {
        html += `
            <tr>
                <td>${item.DIRECCION}</td>
                <td>${item.ORDEN}</td>
                <td>${item.ENTREGADO ? 'Sí' : 'No'}</td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="verDetallePunto(${idd})">Ver Detalles</button>
                </td>
            </tr>
        `;
    });
    html += `
            </tbody>
        </table>
        <div id="detalle-punto"></div>
    `;
    container.innerHTML = html;

    //Guardar los datos, para usar en ver detalless
    window.puntosEntregaData = data;
}

// Mostrar detalles del punto de entrega
window.verDetallePunto = function(idx) {
    const item = window.puntosEntregaData[idx];
    const detalleDiv = document.getElementById("detalle-punto");
    if (!detalleDiv) return;
    detalleDiv.innerHTML = `
        <div class="card mt-3">
            <div class="card-header">
                Detalles del Punto de Entrega
            </div>
            <div class="card-body">
                <p><strong>Ruta:</strong> ${item.ruta ? item.ruta.NOMBRE : 'Sin ruta'}</p>
                <p><strong>Fecha de Ruta:</strong> ${item.ruta ? item.ruta.FECHA : ''}</p>
                <p><strong>Chofer:</strong> ${item.ruta ? item.ruta.IDCHOFER : 'Sin Chofer Asignador'}</p>

            </div>
        </div>
    `;
}

// Cargar puntos al activar la pestaña
document.getElementById('puntos-tab').addEventListener('shown.bs.tab', getPuntos);