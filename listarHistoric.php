<?php
include_once('./herramientas/conexion.php');

if (!empty($_POST['busqueda'])) {
    $data = $_POST['busqueda'];
    $consulta = $pdo->prepare("
        SELECT tr.*, t.*, r.name AS room_name, `table`.name AS table_name, u.fullName AS user_name
        FROM tableRegister tr
        JOIN `table` t ON tr.table_id = t.id
        JOIN room r ON t.room_id = r.id
        JOIN user u ON tr.user_id = u.id
        WHERE 
            tr.id LIKE '%" . $data . "%' OR 
            tr.fecha LIKE '%" . $data . "%' OR 
            tr.set_available LIKE '%" . $data . "%' OR 
            t.id LIKE '%" . $data . "%' OR 
            u.id LIKE '%" . $data . "%' OR 
            r.name LIKE '%" . $data . "%' OR 
            `table`.name LIKE '%" . $data . "%' OR 
            u.fullName LIKE '%" . $data . "%'
    ");

    $consulta->execute();
    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
} else {
    $consulta = $pdo->prepare("SELECT tr.*, t.*, r.*, u.*, r.name AS room_name
        FROM tableRegister tr
        JOIN `table` t ON tr.table_id = t.id
        JOIN room r ON t.room_id = r.id
        JOIN user u ON tr.user_id = u.id;
    ");
    $consulta->execute();
}

$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

// Modificamos el array resultado antes de convertirlo a JSON
foreach ($resultado as &$row) {
    $row['set_available'] = ($row['set_available'] == 1) ? '<span style="color: green;">Libre</span>' : '<span style="color: red;">Ocupado</span>';
}

echo json_encode($resultado);
?>
