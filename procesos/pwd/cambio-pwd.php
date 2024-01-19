<?php

session_start();

if (!isset($_SESSION["changePassword"]) || $_SESSION["changePassword"] != true) {
    header("location: ../../index.php");
    exit();
}

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
    <link rel="stylesheet" href="../../css/login.css">
    <link rel="stylesheet" href="../../css/_styles.css">
    <!-- TÍTULO -->
    <title>Datos usuario</title>
</head>

<body>
    <div id='cont-form'>
        <div id='cont-tit'>
            <h1 id='tit'>Cambio de contraseña</h1>
        </div>

        <div id='form'>
            <?php
                if (isset($_GET["error"]) && $_GET["error"] === "samePass") {
                    ?>
                        <script>
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "No puedes repetir la contraseña.",
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            });
                        </script>
                    <?php
                }
            ?>  

            <form action="./check-pwd.php" method="post">
                <div id='cont-error'>
                    <?php if (isset($_GET["error"])): ?>
                        <?php if ($_GET["error"] === "passMal"): ?>
                            <p id='error-txt' style="color: red;">Las contraseñas no coinciden.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                    <p id='error-txt' style="color: red; display: none;">Ambas contraseñas deben ser iguales.</p>
                </div>

                <div>
                    <label for="pwd">Contraseña:</label>
                    <br>
                    <input type="password" id="pwd" name="pwd" onfocusout="validarPwd(this)" style="width:20vw; border-radius: 5px;">
                    <br>
                    <span id="pwd_error" class="error" style="color: red;"></span>
                </div>

                <br>

                <div>
                    <label for="pwd2">Repite la contraseña:</label>
                    <br>
                    <input type="password" id="pwd2" name="pwd2" onfocusout="validarPwd(this)" style="width:20vw; border-radius: 5px;">
                    <br>
                    <span id="pwd2_error" class="error" style="color: red;"></span>
                </div>

                <br>

                <div>
                    <span id="pwd_diff" class="error" style="color: red;"></span>
                </div>

                <br>

                <div>
                    <input type="submit" name="enviar" id="enviar" value="Enviar" disabled>
                </div>
            </form>

            <div>
                <a href="../../index.php">
                    <button id="volver">Volver a inicio de sesión</button>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Función para validar el formulario
        function validarFormulario() {
            var contra1 = document.getElementById("pwd").value;
            var contra2 = document.getElementById("pwd2").value;

            // Verificar si todos los campos están llenos y las contraseñas coinciden
            if (contra1 !== "" && contra2 !== "" && contra1 === contra2) {
                document.getElementById("enviar").disabled = false; // Habilitar el botón de envío
                document.getElementById("error-txt").style.display = "none"; // Ocultar mensaje de error
            } else {
                document.getElementById("enviar").disabled = true; // Deshabilitar el botón de envío
            }
        }

        // Agregar eventos 'input' a los campos para llamar a la función de validación
        document.getElementById("pwd").addEventListener("input", validarFormulario);
        document.getElementById("pwd2").addEventListener("input", validarFormulario);

        // Llamar a la función de validación inicialmente
        validarFormulario();
    </script>

    <script>
        // Función para validar la contraseña
        function validarPwd(input) {
            const pwd = input.value;
            const errorInput = input;
            const passDiff = document.getElementById("pwd_diff");
            const errorSpan = document.getElementById(input.id + "_error");

            if (pwd.trim() === "") {
                errorSpan.textContent = "Este campo es obligatorio.";
                errorSpan.style.color = "red";
                errorInput.style.borderColor = "red";
                passDiff.textContent = ""; // Limpiar el mensaje de diferencia de contraseñas
            } else if (pwd.length < 9) {
                errorSpan.textContent = "La contraseña debe contener al menos 9 caracteres.";
                errorSpan.style.color = "red";
                errorInput.style.borderColor = "red";
                passDiff.textContent = ""; // Limpiar el mensaje de diferencia de contraseñas
            } else {
                errorSpan.textContent = "";
                errorInput.style.borderColor = "blue";

                // Verificar si ambas contraseñas son iguales
                const pwd1 = document.getElementById("pwd").value;
                const pwd2 = document.getElementById("pwd2").value;
                if (pwd1 !== pwd2) {
                    passDiff.textContent = "Ambas contraseñas deben ser iguales.";
                    passDiff.style.color = "red";
                } else {
                    passDiff.textContent = ""; // Limpiar el mensaje de diferencia de contraseñas
                }
            }

            // Validar el formulario después de la validación de la contraseña
            validarFormulario();
        }
    </script>
</body>

</html>
