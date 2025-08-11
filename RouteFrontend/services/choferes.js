const API_URL = "http://127.0.0.1:8000/api/drivers";

//METODO GET - DEVOLVER LOS CHOFERES
async function getDrivers() {
    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error(`Status: ${response.status}`);
        const result = await response.json();
        renderList(result.data);
    } catch (error) {
        alert(error.message);
    }
}

//METODO POST - CREAR CHOFER
async function createDrivers(nombre, telefono) {
    try {
        const response = await fetch(API_URL, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ NOMBRE: nombre, TELEFONO: telefono })
        });
        if (!response.ok) throw new Error(`Status: ${response.status}`);
        getDrivers();
    } catch (error) {
        alert(error.message);
    }
}

// PUT: Actualizar chofer
async function updateDrivers(id, nombre, telefono) {
    try {
        const response = await fetch(`${API_URL}/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ NOMBRE: nombre, TELEFONO: telefono })
        });
        if (!response.ok) throw new Error(`Status: ${response.status}`);
        getDrivers();
    } catch (error) {
        alert(error.message);
    }
}

//METODO PUT - ACTUALIZR UN REGISTRO
async function deleteDrivers(IDCHOFER) {
    if (!confirm("¿Seguro que deseas eliminar este chofer?")) return;
    try {
        const response = await fetch(`${API_URL}/${IDCHOFER}`, { 
            method: "DELETE" });
        if (!response.ok) throw new Error(`Status: ${response.status}`);
        getDrivers();
    } catch (error) {
        alert(error.message);
    }
}



// Llenar formulario para editar
function completeDataDrivers(id, nombre, telefono) {
    document.getElementById("chofer-id").value = id;
    document.getElementById("chofer-nombre").value = nombre;
    document.getElementById("chofer-telefono").value = telefono;
    document.getElementById("chofer-submit").textContent = "Actualizar Registro";
}


// Renderizar tabla de choferes y formulario
function renderList(data) {
    const container = document.getElementById("drivers-container");
    if (!container) return;
    let html = `
        <h2>Gestionar Choferes</h2>
        <form id="chofer-form" class="row g-3 mb-4">
            <input type="hidden" id="chofer-id">
            <div class="col-md-5">
                <input type="text" class="form-control" id="chofer-nombre" placeholder="Nombre" required>
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control" id="chofer-telefono" placeholder="Teléfono " required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-success" id="chofer-submit">Agregar Registro</button>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
    `;
    data.forEach(item => {
        html += `
            <tr>
                <td>${item.IDCHOFER}</td>
                <td>${item.NOMBRE}</td>
                <td>${item.TELEFONO}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="completeDataDrivers(${item.IDCHOFER}, '${item.NOMBRE}', '${item.TELEFONO}')">Editar</button>    
                    <button class="btn btn-sm btn-danger" onclick="deleteDrivers(${item.IDCHOFER})">Eliminar</button>
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
    document.getElementById("chofer-form").onsubmit = function(e) {
        e.preventDefault();
        const id = document.getElementById("chofer-id").value;
        const nombre = document.getElementById("chofer-nombre").value;
        const telefono = document.getElementById("chofer-telefono").value;
        if (id) {
            updateDrivers(id, nombre, telefono);
        } else {
            createDrivers(nombre, telefono);
        }
        this.reset();
        document.getElementById("chofer-submit").textContent = "Agregar Registro";
    };
}


// Mostrar choferes al cargar
window.onload = getDrivers;