<?php
session_start();

include("../../herramientas/conexion.php");

try {
    $email = $_SESSION["email"];
    $pwd = $_SESSION["pwd"];

    // Utilizamos parámetros con marcadores de posición para prevenir inyecciones SQL
    $sql = "SELECT pwd, email FROM user WHERE email = :email";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) 
    {
        if (password_verify($pwd, $row["pwd"])) {
            $_SESSION["changePassword"] = true;
            header("Location: ./cambio-pwd.php");
            exit();
        } else {
            header("Location: ./datos-usuario.php?error=UserMal");
            exit();
        }
    }
    else
    {
        header("Location: ./datos-usuario.php?error=UserMal");
        exit();
    }

} catch(PDOException $e) {
    echo "Error al acceder al cambio de contraseña: ".$e->getMessage();
    die();
}
?>
