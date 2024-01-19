<?php
    include_once('../herramientas/conexion.php');

    if (!empty($_POST['busqueda'])) {
        $data = $_POST['busqueda'];
        $consulta = $pdo->prepare("SELECT id, table_id, user_id, set_available, date FROM tableregister WHERE id LIKE '%$data%' OR date LIKE '%$data%' OR set_available LIKE '%$data%' OR table_id LIKE '%$data%' OR user_id LIKE '%$data%'");
        $consulta->execute();
    } else {
        $consulta = $pdo->prepare("SELECT * FROM tableregister");
        $consulta->execute();
    }

    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo json_encode($resultado);
    } else {
        echo json_encode(array()); // Si no hay resultados, devuelve un array vacío.
    }
?>
