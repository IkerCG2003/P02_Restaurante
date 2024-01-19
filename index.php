<?php
    session_start();   
    session_destroy();  
    session_abort();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Sweet alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Quicksand:wght@300&display=swap" rel="stylesheet">
        <!-- CSS -->
        <link rel="stylesheet" href="./css/login.css">
        <link rel="stylesheet" href="./css/_styles.css">
        <!-- Título -->
        <title>Inicio de sesión</title>
    </head>

    <body>        
        <div id='cont-form'>
            <div id='cont-tit'>
                <h1 id='tit'>Inicio de sesión</h1>
            </div>


            <div id='form'>
                <div id='cont-error'>
                    <?php
                        if (isset($_GET["message"]) && $_GET["message"] === "userMal") {
                            ?>
                                <script>
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: "Se ha cambiado la contraseña",
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true
                                    });
                                </script>
                            <?php
                        }
                    ?>  

                    <?php
                        if (isset($_GET["message"]) && $_GET["message"] === "cambioPass") {
                            ?>
                                <script>
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: "Se ha cambiado la contraseña",
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true
                                    });
                                </script>
                            <?php
                        }
                    ?>  

                    <?php
                        if (isset($_GET["error"]) && $_GET["error"] === "UserMal") {
                            ?>
                                <script>
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "error",
                                        title: "Datos incorrectos.",
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true
                                    });
                                </script>
                            <?php
                        }
                    ?>  
                </div>

                <form action="./procesos/login/validar-login.php" method="post">
                    <div id="cont-email">
                        <label for="email">Email:</label>
                        <br>
                        <input type="text" id="email" name="email" onfocusout="validarEmail(this)" style="width:20vw; border: radius 5px;">
                        <br>
                        <span id="email_error" class="error" style="color: red;"></span>
                    </div>

                    <br>

                    <div id="cont-pwd">
                        <label for="pwd">Contraseña:</label>
                        <br>
                        <input type="password" id="pwd" name="pwd" onfocusout="validarPwd(this)" style="width:20vw; border: radius 5px;">
                        <br>
                        <span id="pwd_error" class="error" style="color: red;"></span>
                    </div>

                    <br>

                    <div id="cont-sel">
                        <label for="sel">Rol:</label>
                        <br>
                        <select id="rol" name="rol" onchange="validarSel(this)" style="width:20vw; border-radius: 5px;">
                            <option value="" disabled selected>Seleccione un rol</option>
                            <option value="cocinero">Cocinero</option>
                            <option value="camarero">Camarero</option>
                            <option value="mesero">Mesero</option>
                            <option value="gerente">Gerente</option>
                        </select>
                        <br>
                        <span id="rol_error" class="error" style="color: red;"></span>
                    </div>
                    
                    <br><br>

                    <input type="submit" id="enviar" name="enviar" value="Enviar" disabled>

                    <br><br>
                    <a href="./procesos/pwd/datos-usuario.php">Clic aquí para cambiar la contraseña</a>
                </form>
            </div>
        </div>

        <script src="./js/validar-login.js"></script> <!-- Script que valida los campos del formulario -->

        <script>
            // Función para validar el formulario
            function validarFormulario() {
                var email = document.getElementById("email").value;
                var pwd = document.getElementById("pwd").value;
            
                // Verificar si todos los campos están llenos
                if (email !== "" && pwd !== "" ) 
                {
                    document.getElementById("enviar").disabled = false; // Habilitar el botón de envío
                } 
                
                else 
                {
                    document.getElementById("enviar").disabled = true; // Deshabilitar el botón de envío
                }
            }
            
            // Agregar eventos 'input' a los campos para llamar a la función de validación
            document.getElementById("email").addEventListener("input", validarFormulario);
            document.getElementById("pwd").addEventListener("input", validarFormulario);

            // Llamar a la función de validación inicialmente
            validarFormulario();
        </script>
    </body>
</html>