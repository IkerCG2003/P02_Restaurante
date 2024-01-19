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
        <link rel="stylesheet" href="../../css/login.css">
        <link rel="stylesheet" href="../../css/_styles.css">
        <!-- TÍTULO -->
        <title>Datos usuario</title>
    </head>

    <body>
        <div id="cont-form">
            <div id='cont-tit'>
                <h1 id='tit'>Introduce tus datos</h1>
            </div>

            <?php
                if (isset($_GET["error"]) && $_GET["error"] === "UserMal") {
                    ?>
                        <script>
                            Swal.fire({
                                position: "center",
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

            <div id='form'>
                <form action="./validar-datos.php" method="post">
                    <div id='cont-error'>
                        <p id='error-txt'>
                            <?php
                                if (isset($_GET["error"]) && $_GET["error"] === "UserMal") {
                                    echo "<p style='color: red;'>Usuario o contraseña incorrecto</p>";
                                } 
                            ?>
                        </p>
                    </div>


                    <div>
                        <label for="email">Email:</label>
                        <br>
                        <input type="text" id="email" name="email" onfocusout="validarEmail(this)" style="width:20vw; border: radius 5px;">
                        <br>
                        <span id="email_error" class="error" style="color: red;"></span>
                    </div>

                    <br>

                    <div>
                        <label for="tel">Contraseña:</label>
                        <br>
                        <input type="password" id="pwd" name="pwd" onfocusout="validarPwd(this)" style="width:20vw; border: radius 5px;">
                        <br>
                        <span id="pwd_error" class="error" style="color: red;"></span>
                    </div>

                    <br>

                    <div>
                        <input type="submit" name="enviar" id="enviar" disabled>
                    </div>
                </form>

                
                <div>
                    <a href="../../index.php">
                        <button id="volver">Volver a inicio de sesión</button>
                    </a>
                </div>
            </div>
        </div>

        <script src="../../js/validar-login.js"></script>

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