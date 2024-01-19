function filterResults(page, limitPerPage) {
    // Obtener los valores de los filtros
    const tableId = document.querySelector('input[name="tableId"]').value;
    const roomName = document.querySelector('input[name="roomName"]').value;
    const fullName = document.querySelector('input[name="fullName"]').value;

    // Enviar una solicitud AJAX al servidor
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../historico_listar.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status === 200) {
            // Procesar la respuesta del servidor
            const response = JSON.parse(xhr.responseText);

            // Actualizar la tabla con los nuevos registros
            updateTable(response, page, limitPerPage);
        } else {
            console.error('Error al actualizar la tabla');
        }
    };

    xhr.send(`tableId=${tableId}&roomName=${roomName}&fullName=${fullName}&page=${page}&limitPerPage=${limitPerPage}`);
}

function updateTable(data, page, limitPerPage) {
    // Vaciar la tabla actual
    const table = document.querySelector('#historic_table');
    table.innerHTML = '';

    // Calcular los límites de la página actual
    const offset = (page - 1) * limitPerPage;
    const limit = offset + limitPerPage;

    // Recorrer los registros y agregarlos a la tabla
    const rows = data.slice(offset, limit);
    table.innerHTML += rows.map(row => `<tr><td>${row.id}</td><td>${row.fecha}</td><td>${row.set_available ? 'Sí' : 'No'}</td><td>${row.table_id}</td><td>${row.user_id}</td></tr>`).join('');
}

// Al cargar la página, se envía la solicitud AJAX para cargar los resultados
document.addEventListener('DOMContentLoaded', function () {
    filterResults(1, 10);
});
