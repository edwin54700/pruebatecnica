<?php
include '../includes/db.php';
include '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $player = getPlayerById($id);
    
    if (!$player) {
        echo "Jugador no encontrado.";
        exit;
    }
} else {
    echo "ID de jugador no proporcionado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    editPlayer($id, $name, $player['money']);
    header('Location: ../index.php'); // Redirigir después de editar
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Jugador</title>
</head>
<body>
    <h1>Editar Jugador</h1>
    <form action="" method="post">
        <input type="text" name="name" value="<?php echo $player['name']; ?>" required>
        <button type="submit">Guardar Cambios</button>
    </form>
    <a href="../index.php">Volver</a>
</body>
</html>

