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
            <form action="" method="post" id="frmAgregar">
                <input type="hidden" name="idp" id="idp" value="">

                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <select name="rol" id="rol">
                        <option value="" disabled>-- Selecciona una opción --</option>
                        <option value="camarero">Camarero</option>
                        <option value="mesero">Mesero</option>
                        <option value="administrador">Administrador</option>
                        <option value="chef">Chef</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pwd">Contraseña:</label>
                    <input type="password" name="pwd" id="pwd" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" id="btn-enviar" class="btn btn-primary">Agregar</button>
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
