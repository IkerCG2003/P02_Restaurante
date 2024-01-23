<?php
    // Se recogen los campos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    $pwd = $_POST['pwd'];

    include_once("./herramientas/conexion.php");

    try
    {
        if (empty($_POST['idp'])) 
        {
            $query = $pdo->prepare("INSERT INTO user (nombre, apellido, fullname, email, rol, pwd) VALUES (:nom, :ape, :full, :email, :rol, :pwd)");

            $query->bindParam(":nom", $nombre);
            $query->bindParam(":ape", $apellido);
            $query->bindParam(":full", $fullname);
            $query->bindParam(":email", $email);
            $query->bindParam(":rol", $rol);
            $query->bindParam(":pwd", $pwd);

            $query->execute();
            $pdo = null;
            echo "ok";
        } 

        else 
        {
            $id = $_POST['idp'];

            $query = $pdo->prepare("UPDATE user SET nombre = :nombre, apellido = :apellido, fullname = :fullname, email = :email, rol = :rol, pwd = :pwd WHERE id = :id");

            $query->bindParam(":nombre", $nombre);
            $query->bindParam(":apellido", $apellido);
            $query->bindParam(":fullname", $fullname);
            $query->bindParam(":email", $email);
            $query->bindParam(":rol", $rol);
            $query->bindParam(":pwd", $pwd);
            $query->bindParam(":id", $id);
            
            $query->execute();
            $pdo = null;
            echo "modificado";
        }
    } 
    
    catch (PDOException $e) 
    {
        echo "Error: " . $e->getMessage();
    }
?>
