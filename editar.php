<?php
    require "./herramientas/conexion.php";
    $id=$_POST['id'];
    $query = $pdo->prepare("SELECT * FROM user WHERE id = :id");
    $query->bindParam(":id", $id);
    $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($resultado);
?>