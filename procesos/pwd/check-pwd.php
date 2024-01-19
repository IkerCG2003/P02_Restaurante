<?php
session_start();
$email = $_SESSION["email"];

include("../../herramientas/conexion.php");

try {
    $pwd = $_POST['pwd'];
    $pwd2 = $_POST['pwd2'];

    // Consulta para obtener la contraseña actual del usuario
    $sql1 = "SELECT pwd FROM user WHERE email = :email";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt1->execute();
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($row1) 
    {
        $pwdBD = $row1["pwd"];

        // Verifica que la contraseña proporcionada coincida con la almacenada en la base de datos
        if (password_verify($pwd, $pwdBD)) 
        {
            header("Location: ./cambio-pwd.php?error=samePass");
            exit();
        } 
        else 
        {
            // Hashea la nueva contraseña antes de almacenarla en la base de datos
            $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);

            // Actualiza la contraseña del usuario en la base de datos
            $sql2 = "UPDATE user SET pwd = :hashedPwd WHERE email = :email";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->bindParam(':hashedPwd', $hashedPwd, PDO::PARAM_STR);
            $stmt2->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt2->execute();

            header("Location: ../../index.php?message=cambioPass");
            exit();
        }
    } 
    $pdo = null; // Cierra la conexión
} catch (PDOException $e) {
    echo "Error al comprobar las contraseñas: " . $e->getMessage();
    die();
}
?>
