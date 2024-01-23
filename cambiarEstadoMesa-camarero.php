<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("location: ./index.php");
    exit();
}

if (!isset($_GET["form_table"]) || !isset($_GET["form_table_available"])) {
    header("location: ./camarero.php");
    exit();
}

include_once("./herramientas/conexion.php"); // Asegúrate de que este archivo contiene la conexión PDO

try {
    $pdo->beginTransaction();

    // Variables para actualizar e insertar
    $table_id = $_GET["form_table"];
    $new_available_status = ($_GET["form_table_available"] == "0") ? true : false;
    $room_id = $_GET["form_room_id"];
    $user_id = $_SESSION["user_id"];

    // SQL para actualizar la tabla `table`
    $sql_update = "UPDATE `table` SET available = :new_available_status WHERE id = :table_id";

    // SQL para insertar en la tabla `tableRegister`
    $sql_insert = "INSERT INTO tableRegister (set_available, table_id, user_id) VALUES (:new_available_status, :table_id, :user_id)";

    // Preparar y ejecutar la actualización
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->bindParam(':new_available_status', $new_available_status, PDO::PARAM_BOOL);
    $stmt_update->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt_update->execute();

    // Preparar y ejecutar el insert
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->bindParam(':new_available_status', $new_available_status, PDO::PARAM_BOOL);
    $stmt_insert->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt_insert->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_insert->execute();

    $pdo->commit();

    // Cerrar las declaraciones preparadas
    $stmt_update = null;
    $stmt_insert = null;

    header('location: ./camarero.php?room='.$room_id);

} 

catch (PDOException $e) 
{
    $pdo->rollBack();
    echo "Error al editar la mesa: ".$e->getMessage();
    die();
}
?>
