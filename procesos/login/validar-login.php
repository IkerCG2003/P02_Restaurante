<?php
    session_start();

    if (!isset($_POST["email"]) || !isset($_POST["pwd"])) 
    {
        header("Location: ../../index.php?error=Has de rellenar el formulario");
        exit();
    } 

    else 
    {
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        $rol = $_POST["rol"];

        $_SESSION["email"] = $email;
        $_SESSION["pwd"] = $pwd;
        $_SESSION['rol'] = $rol;

        header("Location: ./check-login.php");
        exit();
    }
?>
