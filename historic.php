<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("location: ./index.php");
    exit();
}

include_once("./herramientas/conexion.php");

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = isset($_GET['limitPerPage']) ? (int)$_GET['limitPerPage'] : 10;
$offset = ($page - 1) * $records_per_page;

// Filtros
$filter_tableId = isset($_GET['tableId']) && $_GET['tableId'] !== '' ? '%' . $_GET['tableId'] . '%' : '%';
$filter_roomName = isset($_GET['roomName']) && $_GET['roomName'] !== '' ? '%' . $_GET['roomName'] . '%' : '%';
$filter_fullName = isset($_GET['fullName']) && $_GET['fullName'] !== '' ? '%' . $_GET['fullName'] . '%' : '%';

try {
    // Preparar la consulta
    $query = "SELECT tr.id, t.name as table_name, r.name, tr.table_id, tr.set_available, DATE_FORMAT(`fecha`, '%d/%m - %H:%i') as date, u.fullName 
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
} catch (PDOException $e) {
    echo "Error al leer el histórico: " . $e->getMessage();
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
                    <input class="pagination_input" type="text" name="tableId" placeholder="ID de mesa" onchange="filterResults();">
                    <input class="pagination_input" type="text" name="roomName" placeholder="Nombre de Sala" onchange="filterResults();">
                    <input class="pagination_input" type="text" name="fullName" placeholder="Encargado" onchange="filterResults();">
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
                        <tbody id="historic_tbody"></tbody>
                    </table>

                        <div class="pagination">
                            <form method="get" action="historic.php">
                                <input type="hidden" name="limitPerPage" value="<?php echo $records_per_page ?? ''; ?>">
                                <input type="hidden" name="tableId" value="<?php echo $_GET['tableId'] ?? ''; ?>">
                                <input type="hidden" name="roomName" value="<?php echo $_GET['roomName'] ?? ''; ?>">
                                <input type="hidden" name="fullName" value="<?php echo $_GET['fullName'] ?? ''; ?>">
                                <button class="pagination_button" type="submit" name="page" value="1" <?php if ($page <= 1) echo 'disabled'; ?>>
                                    <img src='./img/backward-fast-solid.svg' width='15px'/></button>
                                <button class="pagination_button" type="submit" name="page" value="<?php echo $page - 1; ?>" <?php if ($page <= 1) echo 'disabled'; ?>>
                                    <img src='./img/backward-solid.svg' width='15px'/></button>
                                    <?php 
                                
                                    $start_page = max($page - 1, 1);
                                    $end_page = min($page + 1, $total_pages);

                                    // Ajustar para mantener siempre tres botones visibles
                                    if ($page == 1) 
                                    {
                                        $end_page = min(3, $total_pages);
                                    }

                                    if ($page == $total_pages) 
                                    {
                                        $start_page = max($total_pages - 2, 1);
                                    }

                                    // Mostrar botones de paginación
                                    for ($i = $start_page; $i <= $end_page; $i++): ?>
                                    <button class="pagination_button" type="submit" name="page" value="<?php echo $i; ?>" <?php if ($i == $page) echo 'disabled'; ?>>
                                        <?php echo $i; ?>
                                    </button>

                                    <?php endfor; ?>

                                    <button class="pagination_button" type="submit" name="page" value="<?php echo $page + 1; ?>" <?php if ($page >= $total_pages)   echo 'disabled'; ?>>
                                    <img src='./img/forward-solid.svg' width='15px'/></button>
                                    <button class="pagination_button" type="submit" name="page" value="<?php echo $total_pages; ?>" <?php if ($page >=  $total_pages) echo 'disabled'; ?>>
                                    <img src='./img/forward-fast-solid.svg' width='15px'/></button>
                                </form>
                            </div>
                        </div>
                    <div class="column-2"></div>
                </div>
            </div>
        </div>

        <script src="./js/script.js"></script>
    </body>
</html>