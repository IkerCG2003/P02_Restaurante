<?php
    session_start();

    if (!isset($_SESSION["email"])) 
    {
        header("location: ../index.php");
        exit();
    }    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS -->
        <link rel="stylesheet" href="./css/crud.css">
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <!-- título -->
        <title>Document</title>
    </head>

    <body>
        <div class="container">
            <div>
                <form action="" method="post" id="frmbusqueda">
                    <div class="form-group">
                    <label for="buscar">Buscar:</label>
                    <input type="text" name="buscar" id="buscar" placeholder="Buscar..." class="form-control">
                    </div>
                </form>
            </div>

            <div>
                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>nombre</th>
                            <th>apellido</th>
                            <th>nombre completo</th>
                            <th>email</th>
                            <th>rol</th>
                            <th>acciones</th>
                        </tr>
                    </thead>

                    <tbody id="resultado"></tbody>
                </table>
            </div>
        </div>

        <div id="paginationControls"></div>
        <div id="paginatedResults">
            <table id="resultadopaginacion">
                <!-- Los resultados se mostrarán aquí -->
            </table>
        </div>

        <script src="./script2.js"></script>
    </body>
</html>