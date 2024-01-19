<?php
    session_start();
    include_once("../herramientas/conexion.php");
    
    try 
    {
        $nameInsert = mysqli_escape_string($conn, $_SESSION["name"]);
        $apellidoInsert = mysqli_escape_string($conn, $_SESSION["apellido"]);
        $fullnameInsert = mysqli_escape_string($conn, $_SESSION["fullname"]);
        $emailInsert = mysqli_escape_string($conn, $_SESSION['emailInsert']);   
        $pwdInsert = mysqli_escape_string($conn, $_SESSION['pwd']);
    
        $sqlFullname = "SELECT * FROM user WHERE fullname = ?;";
        $stmtFullname = mysqli_prepare($conn,$sqlFullname);
        mysqli_stmt_bind_param($stmtFullname , "s" , $fullnameInsert);
        mysqli_stmt_execute($stmtFullname);
        $resultFullname = mysqli_stmt_get_result($stmtFullname);
        $rowFullname = mysqli_fetch_assoc($resultFullname);
    
        if (mysqli_num_rows($resultFullname) > 0)    
        {
            header("Location: ./insertarCamarero.php?error=nameRegistrado");
            exit();
        }
    
        $sqlEmail= "SELECT * FROM user WHERE email = ?;";
        $stmtEmail = mysqli_prepare($conn,$sqlEmail);
        mysqli_stmt_bind_param($stmtEmail , "s" , $emailInsert);
        mysqli_stmt_execute($stmtEmail);
        $resultEmail = mysqli_stmt_get_result($stmtEmail);
        $rowFullname = mysqli_fetch_assoc($resultEmail);
    
        if (mysqli_num_rows($resultEmail) > 0)    
        {
            header("Location: ./insertarCamarero.php?error=emailRegistrado");
            exit();
        }

        $hashedPwd = password_hash($pwdInsert, PASSWORD_BCRYPT);

        $insertCamarero = "INSERT INTO user (Nombre,Apellido,fullName,email,pwd) VALUES (?,?,?,?,?);";
        $stmtInsertCamarero = mysqli_prepare($conn,$insertCamarero);
        mysqli_stmt_bind_param($stmtInsertCamarero , "sssss" , $nameInsert , $apellidoInsert , $fullnameInsert,$emailInsert,$hashedPwd);
        mysqli_stmt_execute($stmtInsertCamarero);

        mysqli_stmt_close($stmtFullname);
        mysqli_stmt_close($stmtEmail);
        mysqli_stmt_close($stmtInsertCamarero);
        mysqli_close($conn);   

        header("Location: ./camareros.php?message=camareroInsertado");
    } 
    
    catch(Exception $e) 
    {
        echo "Error al insertar el usuario: ".$e->getMessage();
        mysqli_close($conn);
        die();
    }
?>