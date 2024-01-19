<?php
    session_start();

    if ($_POST["emailInsert"] == "" || $_POST["pwd"] == "" || $_POST["fullname"] == "" || $_POST["name"] == "" || $_POST["apellido"] == "") 
    {
        header("Location: ./insertarCamarero.php?error=formVacio");
        exit();
    } 

    else 
    {
        $name = $_POST["name"];
        $apellido = $_POST["apellido"];
        $fullname = $_POST["fullname"];
        $email = $_POST["emailInsert"];
        $pwd = $_POST["pwd"];

        $_SESSION["name"] = $name;
        $_SESSION["apellido"] = $apellido;
        $_SESSION["fullname"] = $fullname;
        $_SESSION["emailInsert"] = $email;
        $_SESSION["pwd"] = $pwd;

        header("Location: ./check-insert.php");
        exit();
    }
?>
