<?php
    include_once "./herramientas/conexion.php";
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($id) 
    {
        $query = $pdo->prepare("SELECT nombre, apellido, fullname, email, rol FROM user WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();
        $resultado = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultado);
    }
?>