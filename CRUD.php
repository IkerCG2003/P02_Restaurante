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

        <script src="./script2.js"></script>
    </body>
</html>