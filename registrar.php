<?php
        // Se recogen los campos del formulario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];
        $pwd = $_POST['pwd'];

        include_once("./herramientas/conexion.php");

        // Se controla si se recibe el campo ID
        if (empty($_POST['idp'])) 
        {
            // Si no se recibe quiere decir que se trata de un alta de un registro nuevo
            $query = $pdo->prepare("INSERT INTO user (id, nombre, apellido, fullname, email, rol, pwd) VALUES (null, :nom, :ape, :full, :email, :rol, :pwd)");
            
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
            // Si se recibe el campo IDP, quiere decir que es una actualización de un registro existente
            $id = $_POST['idp'];

            $query = $pdo->prepare("UPDATE user SET nombre = :nom, apellido = :ape, fullname = :full, email = :email, rol = :rol, pwd = :pwd WHERE id = :id");

            $query->bindParam(":nom", $nombre);
            $query->bindParam(":ape", $apellido);
            $query->bindParam(":full", $fullname);
            $query->bindParam(":email", $email);
            $query->bindParam(":rol", $rol);
            $query->bindParam(":pwd", $pwd);
            $query->bindParam(":id", $id);

            $query->execute();
            $pdo = null;
            echo "modificado";
        }
?>
