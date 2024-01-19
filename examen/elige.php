<?php
    session_start();
    $email = $_SESSION["email"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Elige</title>
    </head>

    <body>
        <p>¡Hola <?php echo $email; ?>! Elige qué quieres hacer.</p>

        <ul>
            <li><a href="../index.php">Ver el proyecto original.</a></li>
            <li><a href="./camareros.php">Ver los camareros.</a></li>
        </ul>
    </body>
</html>