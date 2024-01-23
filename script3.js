const buscar = document.getElementById('buscar');
const resultado = document.getElementById('resultado');
const resultadopaginacion = document.getElementById('resultadopaginacion'); // Agregué esta línea para seleccionar el elemento 'resultadopaginacion'
const resultadosPorPagina = 5;
let paginaActual = 1;

function ListarHistoric(valor, pagina = 1) {
    const formdata = new FormData();
    formdata.append('busqueda', valor);

    const ajax = new XMLHttpRequest();
    ajax.open('POST', 'listarHistoric.php');

    ajax.onload = function () {
        let str = "";

        if (ajax.status === 200) {
            const json = JSON.parse(ajax.responseText);
            const totalResultados = json.length;
            const totalPages = Math.ceil(totalResultados / resultadosPorPagina);

            const startIndex = (pagina - 1) * resultadosPorPagina;
            const endIndex = startIndex + resultadosPorPagina;

            let tabla = '';

            for (let i = startIndex; i < endIndex; i++) {
                if (i < totalResultados) {
                    const item = json[i];
                    str = "<tr><td>" + item.id + "</td>";
                    str += "<td>" + item.room_name + "</td>";
                    str += "<td>" + item.table_id + "</td>";
                    str += "<td>" + item.fullname + "</td>";
                    str += "<td>" + item.set_available + "</td>";
                    str += "<td>" + item.fecha + "</td>";
                    str += "</tr>";
                } else {
                    str = "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                }

                tabla += str;
            }

            resultado.innerHTML = tabla;
            actualizarPaginacion(totalPages);
        } else {
            resultado.innerText = 'Error';
        }
    };

    ajax.send(formdata);
}

function actualizarPaginacion(totalPages) {
    resultadopaginacion.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement('button');
        button.textContent = i;
        button.addEventListener('click', function () {
            paginaActual = i;
            ListarHistoric(buscar.value, paginaActual);
        });

        resultadopaginacion.appendChild(button);
    }
}

buscar.addEventListener('keyup', () => {
    const valor = buscar.value;
    if (valor == "") {
        ListarHistoric('', 1); // Cambié 'ListarUser' a 'ListarHistoric'
    } else {
        ListarHistoric(valor, 1);
    }
});

ListarHistoric('', 1); // Cambié 'ListarUser' a 'ListarHistoric'
