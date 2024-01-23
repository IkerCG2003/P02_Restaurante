const buscar = document.getElementById('buscar');
const resultado = document.getElementById('resultado');
const resultadosPorPagina = 5; 
let paginaActual = 1;

function ListarUser(valor, pagina = 1) 
{
    const formdata = new FormData();
    formdata.append('busqueda', valor);

    const ajax = new XMLHttpRequest();
    ajax.open('POST', 'listarUser.php');

    ajax.onload = function () 
    {
        let str = "";

        if (ajax.status === 200) 
        {
            const json = JSON.parse(ajax.responseText);
            const totalResultados = json.length;
            const totalPages = Math.ceil(totalResultados / resultadosPorPagina);

            const startIndex = (pagina - 1) * resultadosPorPagina;
            const endIndex = startIndex + resultadosPorPagina;

            let tabla = '';
            for (let i = startIndex; i < endIndex; i++) 
            {
                if (i < totalResultados) 
                {
                    const item = json[i];
                    str = "<tr><td>" + item.id + "</td>";
                    str += "<td>" + item.nombre + "</td>";
                    str += "<td>" + item.apellido + "</td>";
                    str += "<td>" + item.fullname + "</td>";
                    str += "<td>" + item.email + "</td>";
                    str += "<td>" + item.rol + "</td>";
                    str += "<td>";
                    str += " <button type='button' class='btn btn-success' onclick=" + "Editar(" + item.id + ")>Editar</button>";
                    str += " <button type='button' class='btn btn-danger' onclick=" + "Eliminar(" + item.id + ")>Eliminar</button>";
                    str += "</td> ";
                    str += "</tr>";
                } 
                
                else 
                {
                    str = "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                }
                
                tabla += str;
            }

            resultado.innerHTML = tabla;
            actualizarPaginacion(totalPages);
        } 
        
        else 
        {
            resultado.innerText = 'Error';
        }
    };

    ajax.send(formdata);
}

function actualizarPaginacion(totalPages) 
{
    resultadopaginacion.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) 
    {
        const button = document.createElement('button');
        button.textContent = i;
        button.addEventListener('click', function () {
            paginaActual = i;
            ListarUser(buscar.value, paginaActual);
        });

        resultadopaginacion.appendChild(button);
    }
}

buscar.addEventListener('keyup', () => {
    const valor = buscar.value;
    if (valor == "") 
    {
        ListarUser('', 1);
    } 
    
    else 
    {
        ListarUser(valor, 1);
    }
});

ListarUser('', 1);

function Editar(id) 
{
    var formdata = new FormData();
    formdata.append('id', id);

    var ajax = new XMLHttpRequest();
    ajax.open('POST', 'editar.php');

    ajax.onload = function () 
    {
        if (ajax.status == 200) 
        {
            var json = JSON.parse(ajax.responseText);
            console.log(json);

            document.getElementById('idp').value = json.id;
            document.getElementById('nombre').value = json.nombre;  
            document.getElementById('apellido').value = json.apellido;  
            document.getElementById('fullname').value = json.fullname;  
            document.getElementById('email').value = json.email;  
            document.getElementById('rol').value = json.rol; 
            document.getElementById('pwd').value = json.pwd; 
            document.getElementById('btn-enviar').value = "Actualizar";
        }
    }
    ajax.send(formdata);
}

document.getElementById('btn-enviar').addEventListener("click", () => 
{
    var form = document.getElementById('frm');
    var formdata = new FormData(form);
    var ajax = new XMLHttpRequest();

    ajax.open('POST', 'registrar.php');

    ajax.onload = function () 
    {
        if (ajax.status === 200) 
        {
            if (ajax.responseText == "ok") 
            {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Registrado',
                    showConfirmButton: false,
                    timer: 1500
                });
                form.reset();
                ListarUser('');
            } 
            
            else if (ajax.responseText == "modificado") 
            {  
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Modificado',
                    showConfirmButton: false,
                    timer: 1500
                });

                document.getElementById('btn-enviar').value = "Registrar";
                idp.value = "";
                form.reset();
                ListarUser('');
            } 
            
            else 
            {
                respuesta_ajax.innerText = 'Error';
            }
        } 
        
        else 
        {
            respuesta_ajax.innerText = 'Error';
        }
    }
    ajax.send(formdata);
});

function Eliminar(id) 
{
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        icon: 'warning',
        showCancelButton: true,
        position: 'top-end',
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
                    console.log('Eliminado');
                    if (ajax.responseText === "ok") {
                        ListarUser('');
                        Swal.fire({
                            icon: 'success',
                            position: 'top-end',
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
