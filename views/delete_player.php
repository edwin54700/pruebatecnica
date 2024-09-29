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

    // Eliminar jugador
    deletePlayer($id);
    header('Location: ../index.php'); // Redirigir después de eliminar
} else {
    echo "ID de jugador no proporcionado.";
    exit;
}
?>
