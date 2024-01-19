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
        <h3><a href="./CRUD.php">CRUD CON AJAX</a></h3>
        <h3><a href="./admin.php">PROYECTO NORMAL (HISTORIC.PHP CON AJAX)</a></h3>
    </body>
</html>