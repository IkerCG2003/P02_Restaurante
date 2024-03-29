<?php
    session_start();

    $email = $_SESSION['email'];   
    $pwd = $_SESSION['pwd'];

    try 
    {

        include("../../herramientas/conexion.php");

        // Utilizamos parámetros con marcadores de posición para prevenir inyecciones SQL
        $sql = "SELECT * FROM user WHERE email = :email";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) 
        {
            if (password_verify($pwd, $row['pwd'])) 
            {
                $_SESSION["user_id"] = $row["id"];

                $_SESSION['user_rol'] = $row["rol"];

                // Verifica si el usuario es un administrador y redirige en consecuencia
                if ($row['email'] == 'admin@gmail.com') 
                {
                    header("Location: ../../intermedio.php");
                    exit();
                } 
                
                if ($row['rol']  == 'Camarero') 
                {

                    header("Location: ../../camarero.php");
                    exit();
                }

                else 
                {
                    header("Location: ../../index.php?error=nopermisos");
                    exit();
                }
            } 

            else 
            {
                header("Location: ../../index.php?error=UserMal");
                exit();
            }
        } 
        else 
        {
            header("Location: ../../index.php?error=UserMal");
            exit();
        }

    } 
    catch(PDOException $e) 
    {
        echo "Error al iniciar sesión: ".$e->getMessage();
        die();
    }
?>
