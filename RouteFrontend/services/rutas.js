async function listRutas() {
    const url = "http://127.0.0.1:8000/api/routes";
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

    const result = await response.json();
    renderTable(result.data); 
    } catch (error) {
        console.error(error.message);
    }
}

//Boostrap para mostrar los datos en una tabla
function renderTable(data) {
    const container = document.getElementById("data-container");
    if (!container) return;
        let html = `
        <table class="table table-striped">
            <thead>
                <tr>
                <th>NOMBRE</th>
                <th>FECHA</th>
                </tr>
            </thead>
            <tbody>
        `;

    data.forEach((item) => {
        html += `
        <tr>
            <td>${item.NOMBRE}</td>
            <td>${item.FECHA}</td>
        </tr>
        `;
    });

    html += `
        </tbody>
        </table>
    `;

    container.innerHTML = html;
}

//LLamar a mi func
window.onload = getData;
