buscar.addEventListener("keyup", () => {
    const valor = buscar.value;
    if (valor == "") {
        ListarProductos('');
    }else{
        ListarProductos(valor);
    }
});

ListarProductos('');

function ListarProductos(valor) {
    var resultado = document.getElementById('resultado');

    var formdata = new FormData();

    formdata.append('busqueda', valor);
    
    var ajax = new XMLHttpRequest();

    ajax.open('POST', 'listarUser.php');

    ajax.onload = function () 
    {
        var str="";

        if (ajax.status == 200) 
        {
            var json=JSON.parse(ajax.responseText);
            var tabla='';
            json.forEach(function(item) 
            {
                str="<tr><td>" + item.id + "</td>";
                str=str+"<td>" + item.Nombre + "</td>";
                str+="<td>" + item.Apellido +  "</td>";
                str+="<td>" + item.fullname + "</td>";
                str+="<td>" + item.email + "</td>";
                str+="<td>";
                str=str+ " <button type='button' class='btn btn-success' onclick="+"Editar(" + item.id + ")>Editar</button>";
                str=str+ " <button type='button' class='btn btn-danger' onclick="+"Eliminar(" + item.id + ")>Eliminar</button>";  
                str+="</td> ";       
                str+="</tr>";
            tabla += str;
        });
        resultado.innerHTML=tabla;   
        } 
        
        else 
        {
            resultado.innerText = 'Error';
        }
    }
    ajax.send(formdata);

}
