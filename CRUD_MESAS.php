<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("location: ./index.php");
    exit();
}

include_once("./herramientas/conexion.php");

if (isset($_GET["room"])) {
    $room_id = htmlspecialchars($_GET["room"], ENT_QUOTES, 'UTF-8');
}

// Número de resultados por página
$resultadosPorPagina = 10;

// Número de página actual (por defecto es 1 si no se proporciona)
$paginaActual = isset($_GET['page']) ? $_GET['page'] : 1;

// Calcular el índice de inicio para la consulta
$indiceInicio = ($paginaActual - 1) * $resultadosPorPagina;

try {
    $pdo = new PDO("mysql:host=$dbserver;dbname=$dbbasedatos", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($room_id)) {
        // Consultar mesas de $room_id con paginación
        $sql_mesas = "SELECT t.id as table_id, t.name as table_name, t.available as available, 
                        IF(t.available=1, 'Disponible', 'Ocupada') as table_available,
                        IF(t.available=1, 'green', 'red') as table_color 
                FROM `table` t WHERE t.room_id = :room_id LIMIT :inicio, :porPagina";

        $stmt_mesas = $pdo->prepare($sql_mesas);
        $stmt_mesas->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt_mesas->bindParam(':inicio', $indiceInicio, PDO::PARAM_INT);
        $stmt_mesas->bindParam(':porPagina', $resultadosPorPagina, PDO::PARAM_INT);
        $stmt_mesas->execute();
        $resultado_mesas = $stmt_mesas->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultado_mesas) {
            die('Error: Unable to fetch table data');
        }

        // Obtener el total de mesas para la paginación
        $stmt_total_mesas = $pdo->prepare("SELECT COUNT(*) FROM `table` WHERE room_id = :room_id");
        $stmt_total_mesas->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt_total_mesas->execute();
        $totalResultados = $stmt_total_mesas->fetchColumn();
    } else {
        // Consultar salas con paginación
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
                GROUP BY r.id
                LIMIT :inicio, :porPagina";

        $stmt_salas = $pdo->prepare($sql_salas);
        $stmt_salas->bindParam(':inicio', $indiceInicio, PDO::PARAM_INT);
        $stmt_salas->bindParam(':porPagina', $resultadosPorPagina, PDO::PARAM_INT);
        $stmt_salas->execute();
        $resultado_salas = $stmt_salas->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultado_salas) {
            die('Error: Unable to fetch room data');
        }

        // Obtener el total de salas para la paginación
        $totalResultados = $pdo->query("SELECT COUNT(*) FROM room")->fetchColumn();

        // Calcular el total de páginas
        $totalPaginas = ceil($totalResultados / $resultadosPorPagina);
    }
} catch (PDOException $e) {
    echo "Error al leer la base de datos: " . $e->getMessage();
    die();
} finally {
    $pdo = null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/_styles.css">
    <title>Página del CRUD de mesas</title>
</head>

<body>
    <div class="container">
        <div class="row-header">
            <div class="column-1 header">
                <div class="header-left"></div>
                <div class="header-center">
                    <h1 class="header-center-index" onclick="window.location.href='CRUD_MESAS.php'" style="background-color: #00000050">Gestión</h1>
                    <h1 class="header-center-historic" onclick="window.location.href='./historic.php'">Histórico</h1>
                    <h1 class="header-center-exit" onclick="window.location.href='./intermedio.php'">Volver</h1>
                </div>
                <div class="header-right"></div>
            </div>
        </div>

        <div class="row content-gestion-header">
            <div class="column-79 content-gestion-header-title">
                <h1>Selecciona la <?php if (isset($room_id)) {echo "mesa";} else {echo "sala";}?></h1>
            </div>
            <div class="column-5 content-gestion-header-return" onclick="window.location.href='./CRUD_MESAS.php'">
                <h1>Atrás</h1>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="column-3 sidebar" id="cont-form">
                <form id="salaForm" method="POST" action="add_mesa.php">
                    <div class="form-group">
                        <label for="tipoSala">Tipo de Sala:</label>
                        <select id="tipoSala" name="tipoSala" required>
                            <option value="terrace" name="terrace">Terraza</option>
                            <option value="hall" value="hall">Comedor</option>
                            <option value="private" name="private">Sala Privada</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cantidadMesas">Cantidad de Mesas:</label>
                        <input type="number" id="cantidadMesas" name="cantidadMesas" min="0" required>
                    </div>

                    <button type="button" onclick="validarFormulario()">Crear Sala</button>
                </form>
            </div>

            <div class="column-9 content" id="cont-mesas">
                <div class="content-gestion">
                    <form name="formMesa" id="formMesa" action="./cambiarEstadoMesa-CRUD_MESA.php" method="GET">
                        <input type="hidden" name="form_room_id" id="form_room_id" value="">
                        <input type="hidden" name="form_table" id="form_table" value="">
                        <input type="hidden" name="form_table_available" id="form_table_available" value="">
                    </form>

                    <div class="row content-gestion-content">
                        <?php
                        if (isset($room_id)) { // imprimir mesas de sala
                            for ($i = 0; $i < $resultadosPorPagina; $i++) {
                                // Check if there are enough elements in the array
                                if (isset($resultado_mesas[$i])) {
                                    $mesa = $resultado_mesas[$i];
                                    $imagenMesa = "./img/room_table.png"; // Ruta por defecto

                                    // Resto de tu código para obtener la imagen de la mesa

                                    echo '
                                    <div class="column-5 content-gestion-content-item" onClick="SendMesa(\'' . $mesa["table_id"] . '\',\'' . $mesa["available"] . '\',\'' . $room_id . '\')">
                                        <div class="content-gestion-content-item-image">
                                            <img src="' . $imagenMesa . '" alt="">
                                        </div>

                                        <div class="content-gestion-content-item-bottom" style="background-color: ' . $mesa["table_color"] . '">
                                            <span><span class="hideAtSmall">' . $mesa["table_name"] . ': </span>' . $mesa["table_available"] . '</span>
                                        </div>
                                    </div>';
                                } else {
                                    // Print blank cells with a specific class for styling
                                    echo '<div class="column-5 content-gestion-content-item content-gestion-content-item-empty"></div>';
                                }
                            }
                        } else { // imprimir salas
                            for ($i = 0; $i < $resultadosPorPagina; $i++) {
                                // Check if there are enough elements in the array
                                if (isset($resultado_salas[$i])) {
                                    $sala = $resultado_salas[$i];
                                    echo '
                                    <div class="column-5 content-gestion-content-item" onclick="window.location.href= \'CRUD_MESAS.php?room=' . $sala["room_id"] . '\'">
                                        <div class="content-gestion-content-item-image">
                                            <img src="./img/room_' . $sala["room_name"] . '.png" alt="">
                                        </div>

                                        <div class="content-gestion-content-item-bottom">
                                            <span><span class="hideAtSmall">Mesas:</span> ' . $sala["table_available"] . '/' . $sala["table_count"] . '</span>
                                        </div>
                                    </div>';
                                } else {
                                    // Print blank cells with a specific class for styling
                                    echo '<div class="column-5 content-gestion-content-item content-gestion-content-item-empty"></div>';
                                }
                            }
                        }
                        ?>
                    </div>

                    <div class="column-12 pagination-row" id="resultadopaginacion">
                        <div id="pagination">
                            <?php
                            // Imprimir enlaces de paginación
                            for ($i = 1; $i <= $totalPaginas; $i++) {
                                echo '<a href="?page=' . $i . '" ' . ($i == $paginaActual ? 'class="active"' : '') . '>' . $i . '</a>';
                            }
                            ?>
                        </div>
                    </div>                
                </div>
            </div>
        </div>

        <!-- Script para las validaciones -->
        <script>
            function validarFormulario() {
                var tipoSala = document.getElementById('tipoSala').value;
                var cantidadMesas = document.getElementById('cantidadMesas').value;

                // Validaciones
                if (tipoSala === "" || cantidadMesas === "") {
                    alert("Todos los campos son obligatorios. Por favor, completa el formulario.");
                    return;
                }

                if (parseInt(cantidadMesas) < 0) {
                    alert("La cantidad de mesas no puede ser un número negativo.");
                    return;
                }

                // Si pasa las validaciones, puedes enviar el formulario o realizar otras acciones.
                document.getElementById('salaForm').submit();
            }

            function SendMesa(id_mesa, mesa_disponible, room_id) {
                document.getElementById("form_room_id").value = room_id;
                document.getElementById("form_table").value = id_mesa;
                document.getElementById("form_table_available").value = mesa_disponible;
                document.forms['formMesa'].submit();
            }
        </script>
    </div>
</body>

</html>
