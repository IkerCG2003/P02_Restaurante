<?php
    session_start();
    $emailUser = $_SESSION["email"];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="./validar-insert.js"></script>
        <title>Insertar camarero</title>
    </head>

    <body>
        <p>Has iniciado sesión como <?php echo $emailUser ?></p>

        <?php
            if (isset($_GET["error"]) && $_GET["error"] === "formVacio") 
            {
                echo "<p style='color:red;'>Has de rellenar el formulario</p>";
            } 
        ?>

        <?php
            if (isset($_GET["error"]) && $_GET["error"] === "nameRegistrado") 
            {
                echo "<p style='color:red;'>El nombre de usuario ya está registrado</p>";
            } 
        ?>

        <?php
            if (isset($_GET["error"]) && $_GET["error"] === "emailRegistrado") 
            {
                echo "<p style='color:red;'>El email ya está registrado</p>";
            } 
        ?>

        <form action="./validar-insert.php" method="post">
            <div>
                <label for="fullname">Nombre:</label>
                <input type="text" name="name" id="name" oninput="validarName(this)">
                <br>
                <span id="name_error" class="error"></span><br><br>
            </div>

            <div>
                <label for="fullname">Apellido:</label>
                <input type="text" name="apellido" id="apellido" oninput="validarApellido(this)">
                <br>
                <span id="apellido_error" class="error"></span><br><br>
            </div>

            <div>
                <label for="fullname">Nombre Completo:</label>
                <input type="text" name="fullname" id="fullname" oninput="validarFullName(this)">
                <br>
                <span id="fullname_error" class="error"></span><br><br>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" name="emailInsert" id="emailInsert" oninput="validarEmail(this)">
                <br>
                <span id="email_error" class="error"></span><br><br>
            </div>

            <div>
                <label for="pwd">Contraseña:</label>
                <input type="password" name="pwd" id="pwd" oninput="validarPwd(this)">
                <br>
                <span id="pwd_error" class="error"></span><br><br>
            </div>

            <div>
                <input type="submit" name="enviar" value="Enviar">
            </div>
        </form>

        <a href="./camareros.php"><button>Volver</button></a>
    </body>
</html>