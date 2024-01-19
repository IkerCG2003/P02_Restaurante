<?php
    $dbserver = "localhost"; // Servidor
    $dbusername = "root"; // Nombre de usuario
    $dbpassword = ""; // Contraseña del usuario
    $dbbasedatos = "db_pr02_restaurante"; // Base de datos a la que nos queremos conectar

    // Con el bloque Try / Catch buscamos errores.
    try 
    {
        $pdo = new PDO("mysql:host=$dbserver;dbname=$dbbasedatos", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 

    // Si detecta excepciones las guarda en la variable $e
    catch (PDOException $e)
    {
        echo "Error en la conexión con la base de datos: " . $e->getMessage() . "<br>"; // Si han saltado excepciones muestra los errores almacenados en $e.
        die();
    }
?>
