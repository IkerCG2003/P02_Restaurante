<?php
include './herramientas/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $tipoSala = $_POST['tipoSala'];
    $imagenSala = $_POST['imagenSala'];
    $cantidadMesas = $_POST['cantidadMesas'];

    // Generar nombre único para la sala
    $nombreSala = $tipoSala . '_' . uniqid();

    // Insertar en la tabla room
    try {
        $stmt = $pdo->prepare("INSERT INTO room (name, img) VALUES (:nombreSala, :imagenSala)");
        $stmt->bindParam(':nombreSala', $nombreSala);
        $stmt->bindParam(':imagenSala', $imagenSala);
        $stmt->execute();
        $room_id = $pdo->lastInsertId(); // Obtener el ID de la sala recién insertada
    } catch (PDOException $e) {
        echo "Error al insertar en la tabla room: " . $e->getMessage();
        die();
    }

    // Insertar en la tabla table
    try {
        $stmt = $pdo->prepare("INSERT INTO `table` (name, capacity, available, room_id, user_id) VALUES (:nombreMesa, :capacidadMesa, 1, :room_id, null)");

        // Generar nombres y capacidades de mesa
        for ($i = 1; $i <= $cantidadMesas; $i++) {
            $nombreMesa = $nombreSala . '_' . sprintf('%02d', $i);
            $capacidadMesa = rand(1, 5);

            $stmt->bindParam(':nombreMesa', $nombreMesa);
            $stmt->bindParam(':capacidadMesa', $capacidadMesa);
            $stmt->bindParam(':room_id', $room_id);

            $stmt->execute();

            header('Location: ./CRUD_MESAS.php?message=salaInsertada');
            die();
        }
    } catch (PDOException $e) {
        echo "Error al insertar en la tabla table: " . $e->getMessage();
        header('Location: ./CRUD_MESAS.php?error=salaNoInsertada');
        die();
    }

}
?>
