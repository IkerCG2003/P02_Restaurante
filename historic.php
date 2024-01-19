<?php
    session_start();

    if (!isset($_SESSION["email"])) 
    {
        header("location: ./index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Historico</title>
    </head>

    <body>
        <form action="" method="post" id="frmbusqueda">
            <div class="form-group">
                <label for="buscar">Buscar:</label>
                <input type="text" name="buscar" id="buscar" placeholder="Buscar..." class="form-control">
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la sala</th>
                    <th>ID de mesa</th>
                    <th>Encargado</th>
                    <th>Libre</th>
                </tr>
            </thead>

            <tbody id="resultado"></tbody>
        </table>

        <script src="./historico.js"></script>
    </body>
</html>