<?php
    include_once('./herramientas/conexion.php');

    if (!empty($_POST['busqueda'])) 
    {
        $data=$_POST['busqueda'];
        $consulta = $pdo->prepare("SELECT * FROM user WHERE id LIKE '%".$data."%' OR Nombre LIKE '%".$data."%' OR Apellido LIKE '%".$data."%' OR fullname LIKE '%".$data."%' OR email LIKE '%".$data."%'");

        $consulta->execute();
    }

    else
    {
        $consulta = $pdo->prepare("SELECT * FROM user");
        $consulta->execute();
    }

    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($resultado);
?>