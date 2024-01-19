function validarEmail(input) 
{
    const email = input.value;
    const errorSpan = document.getElementById("email_error");
    const errorInput = document.getElementById("email");
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    const emailRegex2 = /^[a-zA-Z0-9._-]+@[gmail]+\.[com]{3}$/;

    if (email.trim() === "") 
    {
        errorSpan.textContent = "Este campo es obligatorio.";
        errorInput.style.borderColor="red";
    } 


    else if (!emailRegex.test(email)) 
    {
        errorSpan.textContent = "Ingresa un correo electronico valido del dominio '@gmail.com'.";
        errorSpan.style.color="red";
        errorInput.style.borderColor="red";
    } 

    else if (!emailRegex2.test(email)) {
        errorSpan.textContent = "Ingresa un correo que sea del dominio '@gmail.com'.";
        errorSpan.style.color="red";
        errorInput.style.borderColor="red";

    }
    
    else 
    {
        errorSpan.textContent = "";
        errorInput.style.borderColor="blue";
    }
}

function validarFullName(input) {
    const fullname = input.value;
    const errorSpan = document.getElementById("fullname_error");
    const errorInput = document.getElementById("fullnameapellidos");

    if (fullname.trim() === "") 
    {
        errorSpan.textContent = "Este campo es obligatorio.";
        errorSpan.style.color="red";
        errorInput.style.borderColor="red";
    } 
    
    else if (/^\s|\s$|\d/.test(fullname)) 
    {
        errorSpan.textContent = "El nombre y apellidos no pueden contener números ni espacios al inicio o al final.";
        errorSpan.style.color="red";
        errorInput.style.borderColor="red";
    } 
    
    else 
    {
        errorSpan.textContent = "";
        errorInput.style.borderColor="blue";
    }
}

function validarPwd(input) 
{
    const pwd = input.value;
    const errorInput = document.getElementById("pwd");
    const errorSpan = document.getElementById("pwd_error");
  
    if (pwd.trim() === "") 
    {
      errorSpan.textContent = "Este campo es obligatorio.";
      errorSpan.style.color="red";
      errorInput.style.borderColor="red";
    } 
    
    else if (pwd.length < 9) 
    {
      errorSpan.textContent = "La contraseña debe contener al menos 9 caracteres.";
      errorSpan.style.color="red";
      errorInput.style.borderColor="red";
    } 
    
    else 
    {
      errorSpan.textContent = "";
      errorInput.style.borderColor="blue";
    }
}

// function validarTel(input) {
//   const telefono = input.value;
//   const errorInput = document.getElementById("telefono");
//   const errorSpan = document.getElementById("telefono_error");
//   const telefonoRegex = /^\d{9}$/;

//   if (telefono.trim() === "") 
//   {
//       errorSpan.textContent = "Este campo es obligatorio.";
//       errorSpan.style.color="red";
//       errorInput.style.borderColor="red";
//   } 

//   if (!telefonoRegex.test(telefono)) 
//   {
//       errorSpan.textContent = "Ingresa un numero de telefono válido (9 dígitos).";
//       errorSpan.style.color="red";
//       errorInput.style.borderColor="red";
//   } 
  
//   else 
//   {
//       errorSpan.textContent = "";
//       errorInput.style.borderColor="blue";
//   }
// }

function validarSel(select) {
    const rol = select.value;
    const errorSelect = document.getElementById("rol");
    const errorSpan = document.getElementById("rol_error");

    if (rol.trim() === "") {
        errorSpan.textContent = "Por favor, seleccione un rol.";
        errorSpan.style.color = "red";
        errorSelect.style.borderColor = "red";
    } else {
        errorSpan.textContent = "";
        errorSelect.style.borderColor = "blue";
    }
}


