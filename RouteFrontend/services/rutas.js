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

//METODO PUT - ACTUALIZR UN REGISTRO
async function deleteRoutes(IDRUTAS) {
    if (!confirm("¿Seguro que deseas eliminar este ruta?")) return;
    try {
        const response = await fetch(`${RUTAS_API_URL}/${IDRUTAS}`, { 
            method: "DELETE" });
        if (!response.ok) throw new Error(`Status: ${response.status}`);
        getRoutes();
    } catch (error) {
        alert(error.message);
    }
}

// PUT: Actualizar chofer
/*async function updateRoutes(id, nombre, fecha, idChofer) {
    try {
        const response = await fetch(`${API_URL}/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ NOMBRE: nombre, TELEFONO: telefono, FECHA: fecha, IDCHOFER: idChofer})
        });
        if (!response.ok) throw new Error(`Status: ${response.status}`);
        getDrivers();
    } catch (error) {
        alert(error.message);
    }
}*/

//METODO POST - CREAR ROUTES
async function createRoutes(nombre, fecha, idChofer) {
    try {
        const response = await fetch(RUTAS_API_URL, { 
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ NOMBRE: nombre, FECHA: fecha, IDCHOFER: idChofer })
        });
        if (!response.ok) throw new Error(`Status: ${response.status}`);
        getRoutes();
    } catch (error) {
        alert(error.message);
    }
}

// Llenar formulario para editar
/*function completeDataDrivers(id, nombre, fecha, idChofer) {
    document.getElementById("route-id").value = id;
    document.getElementById("route-nombre").value = nombre;
    document.getElementById("route-fecha").value = fecha;
    document.getElementById("route-idChofer").value = idChofer;
    document.getElementById("route-submit").textContent = "Actualizar Registro";
}*/


function renderRoutes(data) {
    const container = document.getElementById("route-container");
    if (!container) return;
    let html = `
        <h2>Agregar una Nueva Ruta</h2> 
        <form id="route-form" class="row g-3 mb-4">
                <input type="hidden" id="route-id">
                <div class="col-md-5">
                    <input type="text" class="form-control" id="route-nombre" placeholder="Nombre de la ruta" required>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="route-fecha" placeholder="Fecha" required>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="route-idChofer" placeholder="Id Chofer" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-success" id="route-submit">Agregar Registro</button>
                </div>
        </form></h2>

        <h2>Listar Rutas</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>FECHA</th>
                    <th>NOMBRE DEL CHOFER</th>
                    <th>Acciones</th>

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

                <td>
                    <button class="btn btn-sm btn-danger" onclick="deleteRoutes(${item.IDRUTAS})">Eliminar</button>
                </td>


            </tr>
        `;
    });
    html += `
            </tbody>
        </table>
    `;
    container.innerHTML = html;
    // formulario
    document.getElementById("route-form").onsubmit = function(e) {
        e.preventDefault();
        const nombre = document.getElementById("route-nombre").value;
        const date = document.getElementById("route-fecha").value;
        const idChofer = document.getElementById("route-idChofer").value;
        createRoutes(nombre, date, idChofer );
        this.reset();
        document.getElementById("route-submit").textContent = "Agregar Registro";
    };
}

// Mostrar rutas al cargar
window.addEventListener('DOMContentLoaded', getRoutes);