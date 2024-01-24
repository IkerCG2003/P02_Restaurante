<?php
    session_start();

    $email = $_SESSION['email'];   

    echo "Hola " . $email;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <h1>ELIGE QUE QUIERES VER</h1>
        <h3><a href="./CRUD_USERS.php">CRUD DE LOS USUARIOS CON AJAX</a></h3>
        <h3><a href="./admin.php">PROYECTO NORMAL</a></h3>
        <h3><a href="./CRUD_MESAS.php">CRUD DE LAS MESAS CON AJAX</a></h3>
    </body>
</html>