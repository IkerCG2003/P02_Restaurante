const buscar = document.getElementById('buscar');
const resultado = document.getElementById('resultado');
const resultadopaginacion = document.getElementById('resultadopaginacion');
const resultadosPorPagina = 5; // Cambia esto según tu preferencia
let paginaActual = 1;

function ListarProductos(valor, pagina = 1) {
    const formdata = new FormData();
    formdata.append('busqueda', valor);

    const ajax = new XMLHttpRequest();
    ajax.open('POST', 'listarUser.php');

    ajax.onload = function () {
        let str = "";

        if (ajax.status == 200) {
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
                    str += "<td>" + item.Nombre + "</td>";
                    str += "<td>" + item.Apellido + "</td>";
                    str += "<td>" + item.fullname + "</td>";
                    str += "<td>" + item.email + "</td>";
                    str += "<td>" + item.rol + "</td>";
                    str += "<td>";
                    str += " <button type='button' class='btn btn-success' onclick=" + "Editar(" + item.id + ")>Editar</button>";
                    str += " <button type='button' class='btn btn-danger' onclick=" + "Eliminar(" + item.id + ")>Eliminar</button>";
                    str += "</td> ";
                    str += "</tr>";
                } else {
                    // Si no hay suficientes resultados, agregar celdas vacías
                    str = "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
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
            ListarProductos(buscar.value, paginaActual);
        });

        resultadopaginacion.appendChild(button);
    }
}

buscar.addEventListener('keyup', () => {
    const valor = buscar.value;
    if (valor == "") {
        ListarProductos('', 1);
    } else {
        ListarProductos(valor, 1);
    }
});

ListarProductos('', 1);

function Eliminar(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'NO'
    }).then((result) => {
        if (result.isConfirmed) {
            var formdata = new FormData();
            formdata.append('id', id);

            var ajax = new XMLHttpRequest();
            ajax.open('POST', 'eliminar.php');

            ajax.onload = function () {
                if (ajax.status === 200) {
                    if (ajax.responseText === "ok") {
                        ListarProductos('');
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            };

            ajax.send(formdata);
        }
    });
}
