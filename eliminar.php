<?php
require_once "./herramientas/conexion.php";

if (isset($_POST['id'])) {
    $data = $_POST['id'];

    $query = $pdo->prepare("DELETE FROM user WHERE id = :id");
    $query->bindParam(":id", $data);

    if ($query->execute()) {
        echo "ok";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
