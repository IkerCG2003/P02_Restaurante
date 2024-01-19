buscar.addEventListener("keyup", () => {
    const valor = buscar.value;
    if (valor == "") 
    {
        ListarSala('');
    }
    
    else
    {
        ListarSala(valor);
    }
});

// ----------------------
// LISTAR SALA
// ----------------------

ListarSala('');

function ListarSala(valor) {
    var resultado = document.getElementById('resultado');

    var formdata = new FormData();

    formdata.append('busqueda', valor);
    
    var ajax = new XMLHttpRequest();

    ajax.open('POST', './listar.php');

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
                str=str+"<td>" + item.table_id + "</td>";
                str+="<td>" + item.user_id +  "</td>";
                str+="<td>" + item.set_available + "</td>";
                str+="<td>" + item.date + "</td>";
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



