<?php
    session_start();
    $email = $_SESSION["email"];

    // Obtener valores actuales de los campos de búsqueda
    $currentName = isset($_GET['name']) ? $_GET['name'] : '';
    $currentApellido = isset($_GET['apellido']) ? $_GET['apellido'] : '';
    $currentOrdenarPorApellido = isset($_GET['ordenarPorApellido']) ? 'checked' : '';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Camareros registrados</title>
    </head>

    <body>
        <p>Has iniciado sesión con <?php echo htmlspecialchars($email); ?></p> 

        <a href="../login.php" style="text-decoration:none;"><button>Cerrar Sesión</button></a>

        <?php
            if (isset($_GET["message"]) && $_GET["message"] === "camareroInsertado") 
            {
                echo "<p style='color:green;'>Se ha insertado el usuario</p>";
            }
        ?>

        <form method="get" action="?<?php echo http_build_query(['apellido' => $currentApellido, 'ordenarPorApellido' => $currentOrdenarPorApellido]); ?>">
            <input type="text" name="name" value="<?php echo htmlspecialchars($currentName); ?>">
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($currentApellido); ?>">
            <label for="ordenarPorApellido">Ordenar alfabéticamente por apellido:</label>
            <input type="checkbox" name="ordenarPorApellido" id="ordenarPorApellido" <?php echo $currentOrdenarPorApellido; ?>>
            <input type="submit" value="Buscar">
        </form>

        <?php
            try 
            {
                include_once("../herramientas/conexion.php");

                $name = '%' . $currentName . '%';
                $apellido = '%' . $currentApellido . '%';
                $orden = isset($_GET['ordenarPorApellido']) ? 'Apellido' : 'fullname';

                $sql = "SELECT Nombre, Apellido, email, fullname, pwd FROM user WHERE Nombre LIKE ? AND Apellido LIKE ?";

                if (isset($_GET['ordenarPorApellido'])) 
                {
                    $sql .= " ORDER BY Apellido";
                }

                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $name, $apellido);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result) {
                    echo "<table border='1'>";
                        echo "<tr><th>Nombre</th><th>Apellido</th><th>Email</th><th>Fullname</th><th>Password</th></tr>";

                        while ($row = mysqli_fetch_assoc($result)) 
                        {
                            echo "<tr>";

                                $output = "<td>" . htmlspecialchars($row['Nombre']) . "</td>";
                                $output .= "<td>" . htmlspecialchars($row['Apellido']) . "</td>";
                                $output .= "<td>" . htmlspecialchars($row['email']) . "</td>";
                                $output .= "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                                $output .= "<td>" . htmlspecialchars($row['pwd']) . "</td>";

                                if ($row["email"] == $email) 
                                {
                                    $output = "<td style='color:green;font-weight:bolder;'>" . htmlspecialchars($row['Nombre']) . "</td>";
                                    $output .= "<td style='color:green;font-weight:bolder;'>" . htmlspecialchars($row['Apellido']) . "</td>";
                                    $output .= "<td style='color:green;font-weight:bolder;'>" . htmlspecialchars($row['email']) . "</td>";
                                    $output .= "<td style='color:green;font-weight:bolder;'>" . htmlspecialchars($row['fullname']) . "</td>";
                                    $output .= "<td style='color:green;font-weight:bolder;'>" . htmlspecialchars($row['pwd']) . "</td>";
                                }

                                echo $output;
                            echo "</tr>";
                        }
                    echo "</table>";
                } 
                
                else 
                {
                    throw new Exception('Error al encontrar los usuarios: ' . mysqli_error($conn));
                }

                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            } 
            
            catch (Exception $e) 
            {
                echo 'Error al encontrar la base de datos: ',  $e->getMessage(), "\n";
            }
        ?>

        <a href="./insertarCamarero.php" style="text-decoration:none;"><button>Insertar Camarero</button></a>
        <a href="./camareros.php"><button id="quitarFiltro" style="text-decoration:none;">Eliminar Filtro</button></a>
    </body>
</html>
