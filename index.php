<?php
include 'includes/db.php'; // Asegúrate de que esta ruta sea correcta
include 'includes/functions.php'; // Asegúrate de que esta ruta sea correcta

// Verificar si se ha enviado un formulario para agregar un jugador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    // Agregar el nuevo jugador con un saldo inicial de 10,000
    addPlayer($_POST['name'], 10000); // Asegúrate de que la función addPlayer acepte dos parámetros
}

// Obtener la lista de jugadores
$players = getPlayers();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación de Apuestas</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Asegúrate de que esta ruta sea correcta -->
</head>
<body>
    <div class="container">
        <h1>Aplicación de Apuestas</h1>

        <div class="form-container">
            <h2>Agregar Jugador</h2>
            <form action="" method="post">
                <input type="text" name="name" required placeholder="Nombre del Jugador" class="input-field">
                <button type="submit" class="submit-button">Agregar Jugador</button>
            </form>
        </div>

        <div class="table-container">
            <h2>Lista de Jugadores</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Dinero</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $player): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($player['id']); ?></td>
                        <td><?php echo htmlspecialchars($player['name']); ?></td>
                        <td><?php echo htmlspecialchars($player['money']); ?></td>
                        <td>
                            <a href="views/edit_player.php?id=<?php echo $player['id']; ?>" class="action-link">Editar</a>
                            <a href="views/delete_player.php?id=<?php echo $player['id']; ?>" class="action-link">Eliminar</a>
                            <a href="views/roulette.php?id=<?php echo $player['id']; ?>" class="action-link">Apostar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
