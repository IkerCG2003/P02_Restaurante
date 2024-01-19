<?php

session_start();
// if (!isset($_SESSION["user_logged"]) || $_SESSION["user_logged"] != true) {
//     header("location: ./login.php");
//     exit();
// }

include_once("./herramientas/conexion.php");

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;
if ($records_per_page <= 0) $records_per_page = 10; 
$offset = ($page - 1) * $records_per_page;

// Filtros
$filter_tableId = isset($_GET['tableId']) && $_GET['tableId'] !== '' ? '%'.$_GET['tableId'].'%' : '%';
$filter_roomName = isset($_GET['roomName']) && $_GET['roomName'] !== '' ? '%'.$_GET['roomName'].'%' : '%';
$filter_fullName = isset($_GET['fullName']) && $_GET['fullName'] !== '' ? '%'.$_GET['fullName'].'%' : '%';

try {
    // Preparar la consulta
    $query = "SELECT tr.id, t.name as table_name, r.name, tr.table_id, tr.set_available, DATE_FORMAT(`date`, '%d/%m - %H:%i') as date, u.fullName 
    FROM tableRegister tr
    JOIN `table` t ON tr.table_id = t.id
    JOIN room r ON t.room_id = r.id
    JOIN user u ON tr.user_id = u.id
    WHERE t.name LIKE :filter_tableId AND r.name LIKE :filter_roomName AND u.fullName LIKE :filter_fullName
    ORDER BY tr.id DESC
    LIMIT :offset, :records_per_page";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':filter_tableId', $filter_tableId, PDO::PARAM_STR);
    $stmt->bindParam(':filter_roomName', $filter_roomName, PDO::PARAM_STR);
    $stmt->bindParam(':filter_fullName', $filter_fullName, PDO::PARAM_STR);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
    
    // Ejecutar
    $stmt->execute();

    // Obtener resultado
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para la paginación
    $query_total = "SELECT COUNT(*) AS total FROM tableRegister tr
        JOIN `table` t ON tr.table_id = t.id
        JOIN room r ON t.room_id = r.id
        JOIN user u ON tr.user_id = u.id
        WHERE t.name LIKE :filter_tableId AND r.name LIKE :filter_roomName AND u.fullName LIKE :filter_fullName";

    $stmt_total = $pdo->prepare($query_total);
    $stmt_total->bindParam(':filter_tableId', $filter_tableId, PDO::PARAM_STR);
    $stmt_total->bindParam(':filter_roomName', $filter_roomName, PDO::PARAM_STR);
    $stmt_total->bindParam(':filter_fullName', $filter_fullName, PDO::PARAM_STR);
    $stmt_total->execute();

    $total_row = $stmt_total->fetch(PDO::FETCH_ASSOC);
    $total_pages = ceil($total_row['total'] / $records_per_page);
    
} catch(PDOException $e) {
    echo "Error al leer el histórico: ".$e->getMessage();
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/_styles.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="column-1 header">
                <div class="header-left"></div>
                <div class="header-center">
                    <h1 class="header-center-index" onclick="window.location.href='./admin.php'">Gestión</h1>
                    <h1 class="header-center-historic" onclick="window.location.href='./historic.php'" style="background-color: #00000050">Histórico</h1>
                    <h1 class="header-center-exit" onclick="window.location.href='./index.php'">Salir</h1>
                </div>
                <div class="header-right"></div>
            </div>
        </div>
        
        <div class="content">
            <div class="row">
                <div class="column-1 historic_container">
                    <form method="get" class="historic_content">
                        <input class="pagination_input" style="width: 20%" type="text" name="tableId" placeholder="ID de mesa" value="<?php echo $_GET['tableId'] ?? ''; ?>">
                        <input class="pagination_input" style="width: 35%" type="text" name="roomName" placeholder="Nombre de Sala" value="<?php echo $_GET['roomName'] ?? ''; ?>">
                        <input class="pagination_input" style="width: 30%" type="text" name="fullName" placeholder="Encargado" value="<?php echo $_GET['fullName'] ?? ''; ?>">
                        <input class="pagination_input" style="width: 15%; cursor: pointer;" type="submit" value="Buscar">
                    </form>

                    <table class="historic_content" id="historic_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre de sala</th>
                                <th>ID de mesa</th>
                                <th>Encargado</th>
                                <th>Libre</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $count = 0;
                            foreach ($result as $row) {
                                $class = ($count % 2 == 0) ? " class='td_alter'" : "";
                                echo "<tr".$class.">";
                                echo "<td".$class.">".$row['id']."</td>";
                                echo "<td".$class.">".$row['name']."</td>";
                                echo "<td".$class.">".$row['table_name']."</td>";
                                echo "<td".$class.">".$row['fullName']."</td>";
                                echo $row['set_available'] ? '<td'.$class.' style="color: green;">Sí</td>' : '<td'.$class.' style="color: red;">No</td>';
                                echo "<td ".$class.">".$row['date']."</td>";
                                echo "</tr>";
                                $count++;
                            }
                            for ($i=$count; $i < $records_per_page; $i++) { 
                                echo "<tr>";
                                echo "<td class='td_empty'>.</td>";
                                echo "<td class='td_empty'></td>";
                                echo "<td class='td_empty'></td>";
                                echo "<td class='td_empty'></td>";
                                echo "<td class='td_empty'></td>";
                                echo "<td class='td_empty'></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="pagination">
                        <form method="get" action="historic.php">
                            <input type="hidden" name="limitPerPage" value="<?php echo $records_per_page ?? ''; ?>">
                            <input type="hidden" name="tableId" value="<?php echo $_GET['tableId'] ?? ''; ?>">
                            <input type="hidden" name="roomName" value="<?php echo $_GET['roomName'] ?? ''; ?>">
                            <input type="hidden" name="fullName" value="<?php echo $_GET['fullName'] ?? ''; ?>">

                            <!-- Primera Página -->
                            <button class="pagination_button" type="submit" name="page" value="1" <?php if ($page <= 1) echo 'disabled'; ?>>
                            <img src='./img/backward-fast-solid.svg' width='15px'/></button>

                            <!-- Botón Anterior -->
                            <button class="pagination_button" type="submit" name="page" value="<?php echo $page - 1; ?>" <?php if ($page <= 1) echo 'disabled'; ?>>
                            <img src='./img/backward-solid.svg' width='15px'/></button>


                            <!-- Número de Página - Mostrar dos botones de página alrededor de la página actual -->
                            <?php 
                            $start_page = max($page - 1, 1);
                            $end_page = min($page + 1, $total_pages);

                            // Ajustar para mantener siempre tres botones visibles
                            if ($page == 1) {
                                $end_page = min(3, $total_pages);
                            }
                            if ($page == $total_pages) {
                                $start_page = max($total_pages - 2, 1);
                            }

                            for ($i = $start_page; $i <= $end_page; $i++): ?>
                                <button class="pagination_button" type="submit" name="page" value="<?php echo $i; ?>" <?php if ($i == $page) echo 'disabled'; ?>>
                                    <?php echo $i; ?>
                                </button>
                            <?php endfor; ?>

                            <!-- Botón Siguiente -->
                            <button class="pagination_button" type="submit" name="page" value="<?php echo $page + 1; ?>" <?php if ($page >= $total_pages) echo 'disabled'; ?>>
                            <img src='./img/forward-solid.svg' width='15px'/></button>

                            <!-- Última Página -->
                            <button class="pagination_button" type="submit" name="page" value="<?php echo $total_pages; ?>" <?php if ($page >= $total_pages) echo 'disabled'; ?>>
                            <img src='./img/forward-fast-solid.svg' width='15px'/></button>
                        </form>
                    </div>
                </div>
                <div class="column-2">
                    
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>
