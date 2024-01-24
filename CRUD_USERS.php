<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="./css/crud.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
    <!-- título -->
    <title>Document</title>
</head>

<body>
    <div>
        <div class="container-header">
            <div class="row">
                <div class="column-1 header">
                    <div class="header-left"></div>
                    <div class="header-center">
                        <h1 class="header-center-index" onclick="window.location.href='./admin.php'">Gestión</h1>
                        <h1 class="header-center-historic" onclick="window.location.href='./historic.php'" style="background-color: #00000050">Histórico</h1>
                        <h1 class="header-center-exit" onclick="window.location.href='./intermedio.php'">Volver</h1>
                    </div>
                    <div class="header-right"></div>
                </div>
            </div>
        </div>

        <div class="container">
            <div id="frm-register">
                <p style="font-weight: bolder; font-size: 20px;">Inserción de usuarios</p>
                <form action="" method="POST" id="frm">
                    <div class="form-group">
                        <input type="hidden" name="idp" id="idp" value="">
                    </div>


                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Introduce el nombre" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" name="apellido" id="apellido" placeholder="Introduce el apellido" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="fullname">Nombre Completo:</label>
                        <input type="text" name="fullname" id="fullname" placeholder="Introduce el nombre completo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" placeholder="Introduce el email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="rol">Rol:</label>
                        <input type="text" name="rol" id="rol" placeholder="Introduce el rol" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="pwd">Contraseña:</label>
                        <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Introduce la contraseña" required>
                    </div>

                    <div class="form-group">
                        <input type="button" value="Registrar" id="btn-enviar" class="btn btn-primary btn-block" disabled>
                    </div>
                </form>
            </div>

            <div id="cnt-crud">
                <form action="" method="post" id="frmbusqueda">
                    <div class="form-group">
                        <label for="buscar">Buscar:</label>
                        <input type="text" name="buscar" id="buscar" placeholder="Buscar..." class="form-control">
                    </div>
                </form>

                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody id="resultado"></tbody>
                    </table>
                </div>


                <div id="paginationControls"></div>
                <div id="paginatedResults">
                    <table id="resultadopaginacion">
                        <!-- Los resultados se mostrarán aquí -->
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="./script2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Llamada inicial para verificar el estado del botón al cargar la página
            verificarCamposLlenos();

            // Agrega un evento de escucha al formulario
            document.getElementById("frm").addEventListener("input", function () {
                verificarCamposLlenos();
            });

            document.getElementById("btn-enviar").addEventListener("click", function (event) {
                event.preventDefault(); // Evita el envío automático del formulario
                validarFormulario();
            });
        });

        function verificarCamposLlenos() {
            var nombre = document.getElementById('nombre').value;
            var apellido = document.getElementById('apellido').value;
            var fullname = document.getElementById('fullname').value;
            var email = document.getElementById('email').value;
            var rol = document.getElementById('rol').value;
            var pwd = document.getElementById('pwd').value;

            var botonEnviar = document.getElementById('btn-enviar');

            // Habilitar el botón si todos los campos están llenos, deshabilitarlo de lo contrario
            botonEnviar.disabled = !(nombre && apellido && fullname && email && rol && pwd);
        }

        function validarFormulario() {
            var nombre = document.getElementById('nombre').value;
            var apellido = document.getElementById('apellido').value;
            var fullname = document.getElementById('fullname').value;
            var email = document.getElementById('email').value;
            var rol = document.getElementById('rol').value;
            var pwd = document.getElementById('pwd').value;

            // Validaciones
            if (nombre === "" || apellido === "" || fullname === "" || email === "" || rol === "" || pwd === "") {
                alert("Todos los campos son obligatorios. Por favor, completa el formulario.");
                return;
            }

            // Validación de formato de nombre y apellido (solo letras)
            var regexLetras = /^[a-zA-Z\s]*$/; // Acepta solo letras y espacios

            if (!regexLetras.test(nombre) || !regexLetras.test(apellido) || !regexLetras.test(fullname)) {
                alert("Nombre, apellido y nombre completo solo pueden contener letras y espacios.");
                return;
            }

            // Validación de dominio de correo electrónico
            var regexEmail = /^[a-zA-Z0-9._-]+@gmail\.com$/;

            if (!regexEmail.test(email)) {
                alert("El email debe pertenecer al dominio @gmail.com");
                return;
            }

            // Resto de validaciones si es necesario

            // Si pasa las validaciones, puedes enviar el formulario o realizar otras acciones.
            document.getElementById('frm').submit();
        }
    </script>

</body>

</html>
