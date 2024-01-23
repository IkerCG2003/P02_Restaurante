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
    <div class="container">
        <div id="frm-register">
            <p style="font-weight: bolder; font-size: 20px;">Inserción de usuarios</p>
            <form action="" method="POST" id="frm">
                <div class="form-group">
                    <input type="hidden" name="idp" id="idp" value="">
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
                    <input type="button" value="Registrar" id="btn-enviar" class="btn btn-primary btn-block">
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

    <script src="./script2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>
