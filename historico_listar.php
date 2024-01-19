<?php
// Conexión a la base de datos
$db = new PDO('mysql:host=localhost;dbname=restaurante', 'root', '');

// Obtener los valores de los filtros
$tableId = $_POST['tableId'];
$roomName = $_POST['room_name'];
$fullName = $_POST['full_name'];

// Paginación
$page = $_POST['page'] ?? 1;
$limitPerPage = $_POST['limitPerPage'] ?? 10;

// Calcular los límites de la página actual
$offset = (int)($page - 1) * $limitPerPage;

// Consulta SQL con prepared statements
$sql = "SELECT id, fecha, set_available, table_id, user_id
        FROM tableregister
        WHERE table_id = ?
        AND room_name LIKE ?
        AND user_id LIKE ?
        ORDER BY fecha DESC
        LIMIT ?, ?";

// Ejecutar la consulta SQL con prepared statements
$stmt = $db->prepare($sql);
$stmt->bindParam(1, $tableId, PDO::PARAM_STR);
$stmt->bindParam(2, '%' . $roomName . '%', PDO::PARAM_STR);
$stmt->bindParam(3, '%' . $fullName . '%', PDO::PARAM_STR); // Changed from full_name to user_id
$stmt->bindParam(4, $offset, PDO::PARAM_INT);
$stmt->bindParam(5, $limitPerPage, PDO::PARAM_INT);
$stmt->execute();

// Obtener los resultados
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver los resultados
echo json_encode($results);
?>
