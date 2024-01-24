<?php
    session_start();

    if (!isset($_SESSION["email"])) {
        header("location: ./index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/historico.css">
    <title>Histórico</title>
</head>

<body>    
    <div class="container">
        <div class="row-header">
            <div class="column-1 header">
                <div class="header-left"></div>
                <div class="header-center">
                    <h1 class="header-center-index" onclick="window.location.href='./admin.php'">Gestión</h1>
                    <h1 class="header-center-historic" onclick="window.location.href='./historic.php'" style="background-color: #00000050">Histórico</h1>
                    <h1 class="header-center-exit" onclick="window.location.href='./index.php'">Salir</h1>
                </div>
                <div class="header-right"></div>
            </div>
        </div>

        <div class="row content-gestion-header">
            <div class="column-79 content-gestion-header-title">
                <h1>Histórico</h1>
            </div>
            <div class="column-5 content-gestion-header-return" onclick="window.location.href='./CRUD_MESAS.php'">
                <h1>Atrás</h1>
            </div>
        </div>

        <form action="" method="post" id="frmbusqueda">
            <div class="form-group">
                <label for="buscar">Buscar:</label>
                <input type="text" name="buscar" id="buscar" placeholder="Buscar..." class="form-control">
            </div>
        </form>

        <div class="content">
            <div class="row">
                <div class="column-1 historic_container">
                    <table class="historic_content" id="historic_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre de sala</th>
                                <th>ID de mesa</th>
                                <th>Encargado</th>
                                <th>Libre</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody id="resultado"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="paginationControls"></div>
        <div id="paginatedResults">
            <table id="resultadopaginacion">
                <!-- Los resultados se mostrarán aquí -->
            </table>
        </div>
    </div> <!-- Close the container div -->

    <script src="./script3.js"></script>
</body>
</html>
