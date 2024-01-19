<?php
    session_start();

    if (!isset($_POST["email"]) || !isset($_POST["pwd"])) 
    {
        header("Location: ./datos-usuario.php?error=Has de rellenar el formulario");
        exit();
    } 

    else 
    {
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];

        $_SESSION["email"] = $email;
        $_SESSION["pwd"] = $pwd;

        header("Location: ./check-datos.php");
        exit();
    }
?>
