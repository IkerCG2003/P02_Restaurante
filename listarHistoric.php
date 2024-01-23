<?php
        include_once('./herramientas/conexion.php');

        if (!empty($_POST['busqueda'])) 
        {
        $data=$_POST['busqueda'];
        $consulta = $pdo->prepare("SELECT * FROM tableregister WHERE id LIKE '%".$data."%' OR fecha LIKE '%".$data."%' OR set_available LIKE '%".$data."%' OR table_id LIKE '%".$data."%' OR user_id LIKE '%".$data."%'");

        $consulta->execute();
        }

        else
        {
        $consulta = $pdo->prepare("SELECT * FROM tableregister");
        $consulta->execute();
        }

        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($resultado);
?>
