<?php
    session_start();
    if (!isset($_SESSION["email"])) 
    {
        header("location: ../index.php");
        exit();
    }

    include_once("./herramientas/conexion.php");

    if (isset($_GET["room"])) 
    {
        $room_id = htmlspecialchars($_GET["room"], ENT_QUOTES, 'UTF-8');
    }

    try 
    {
        $pdo = new PDO("mysql:host=$dbserver;dbname=$dbbasedatos", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($room_id)) 
        { // consultar mesas de $room_id
            $sql_mesas = "SELECT t.id as table_id, t.name as table_name, t.available as available, 
                                IF(t.available=1, 'Disponible', 'Ocupada') as table_available,
                                IF(t.available=1, 'green', 'red') as table_color 
                        FROM `table` t WHERE t.room_id = :room_id";

            $stmt_mesas = $pdo->prepare($sql_mesas);
            $stmt_mesas->bindParam(':room_id', $room_id, PDO::PARAM_INT);
            $stmt_mesas->execute();
            $resultado_mesas = $stmt_mesas->fetchAll(PDO::FETCH_ASSOC);

            if (!$resultado_mesas) 
            {
                die('Error: Unable to fetch table data');
            }
        } 
        
        else 
        { // consultar salas
            $sql_salas = "SELECT r.id as room_id, 
                                CASE 
                                    WHEN r.name LIKE '%Terraza%' THEN 'terrace'
                                    WHEN r.name LIKE '%Comedor%' THEN 'hall'
                                    WHEN r.name LIKE '%privada%' THEN 'private'
                                    ELSE r.name 
                                END as room_name,
                                count(1) as table_count, 
                                SUM(IF(t.available=1, 1, 0)) as table_available 
                        FROM room r 
                        INNER JOIN `table` t ON t.room_id = r.id 
                        GROUP BY r.id";

            $stmt_salas = $pdo->prepare($sql_salas);
            $stmt_salas->execute();
            $resultado_salas = $stmt_salas->fetchAll(PDO::FETCH_ASSOC);

            if (!$resultado_salas) 
            {
                die('Error: Unable to fetch room data');
            }
        }
    } 

    catch (PDOException $e) 
    {
        echo "Error al leer la base de datos: " . $e->getMessage();
        die();
    } 

    finally 
    {
        $pdo = null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/_styles.css">
    <title>Página del administrador</title>
</head>

<body>
    <div class="container">
        <div class="row-header">
            <div class="column-1 header">
                <div class="header-left"></div>
                <div class="header-center">
                    <h1 class="header-center-index" onclick="window.location.href='admin.php'" style="background-color: #00000050">Gestión</h1>
                    <h1 class="header-center-historic" onclick="window.location.href='./historic.php'">Histórico</h1>
                    <h1 class="header-center-exit" onclick="window.location.href='./intermedio.php'">Volver</h1>
                </div>
                <div class="header-right"></div>
            </div>
        </div>

        <div class="content-gestion">
            <div class="row content-gestion-header">
                <div class="column-79 content-gestion-header-title">
                    <h1>Selecciona la <?php if (isset($room_id)) {echo "mesa";} else {echo "sala";}?></h1>
                </div>
                <div class="column-5 content-gestion-header-return" onclick="window.location.href='./admin.php'">
                    <h1>Atrás</h1>
                </div>
            </div>

            <form name="formMesa" id="formMesa" action="./procesos/cambiarEstadoMesa.php" method="GET">
                <input type="hidden" name="form_room_id" id="form_room_id" value="">
                <input type="hidden" name="form_table" id="form_table" value="">
                <input type="hidden" name="form_table_available" id="form_table_available" value="">
            </form>

            <div class="row content-gestion-content">
                <?php
                if (isset($room_id)) { // imprimir mesas de sala
                    foreach ($resultado_mesas as $mesa) {
                        echo '
                            <div class="column-5 content-gestion-content-item" onClick="SendMesa(\'' . $mesa["table_id"] . '\',\'' . $mesa["available"] . '\',\'' . $room_id . '\')">
                                <div class="content-gestion-content-item-image">
                                    <img src="./img/room_table.png" alt="">
                                </div>
                                <div class="content-gestion-content-item-bottom" style="background-color: ' . $mesa["table_color"] . '">
                                    <span><span class="hideAtSmall">' . $mesa["table_name"] . ': </span>' . $mesa["table_available"] . '</span>
                                </div>
                            </div>';
                    }
                } else { // imprimir salas
                    foreach ($resultado_salas as $sala) {
                        echo '
                            <div class="column-5 content-gestion-content-item" onclick="window.location.href= \'admin.php?room=' . $sala["room_id"] . '\'">
                                <div class="content-gestion-content-item-image">
                                    <img src="./img/room_' . $sala["room_name"] . '.png" alt="">
                                </div>
                                <div class="content-gestion-content-item-bottom">
                                    <span><span class="hideAtSmall">Mesas:</span> ' . $sala["table_available"] . '/' . $sala["table_count"] . '</span>
                                </div>
                            </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        function SendMesa(id_mesa, mesa_disponible, room_id) {
            document.getElementById("form_room_id").value = room_id;
            document.getElementById("form_table").value = id_mesa;
            document.getElementById("form_table_available").value = mesa_disponible;
            document.forms['formMesa'].submit();
        }
    </script>
</body>
</html>
