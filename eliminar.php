<?php
    require_once "conexion.php";
    $data = $_POST['id'];
    
    $query = $pdo->prepare("DELETE FROM productos WHERE id = :id");
    $query->bindParam(":id", $data);
    $query->execute();
    echo "ok";
?>