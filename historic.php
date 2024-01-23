<?php
    session_start();

    if (!isset($_SESSION["email"])) {
        header("location: ./index.php");
        exit();
    }

    include_once("./herramientas/conexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/_styles.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row">
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
                        <tbody id="resultados"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="./script3.js"></script>
    </body>
</html>
