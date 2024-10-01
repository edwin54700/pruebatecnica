<?php
include 'includes/db.php'; // Asegúrate de que esta ruta sea correcta
include 'includes/functions.php'; // Asegúrate de que esta ruta sea correcta

$message = ""; // Para almacenar mensajes de retroalimentación

// Verificar si se ha enviado un formulario para agregar un jugador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    // Agregar el nuevo jugador con un saldo inicial de 10,000
    addPlayer($_POST['name'], 10000); // Asegúrate de que la función addPlayer acepte dos parámetros

    // Redirigir para evitar la duplicación de datos al recargar
    header("Location: gestion.php?success=player_added");
    exit();
}

// Verificar si se ha enviado un formulario para agregar saldo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player_id'], $_POST['amount'])) {
    $player_id = $_POST['player_id'];
    $amount = $_POST['amount'];
    
    // Asegurarse de que el monto es positivo
    if ($amount > 0) {
        // Llamar a la función para agregar saldo
        $message = addBalanceToPlayer($player_id, $amount); // Asegúrate de que la función esté implementada
    } else {
        $message = "El monto debe ser mayor que 0.";
    }

    // Redirigir para evitar la duplicación de datos al recargar
    header("Location: gestion.php?success=balance_added");
    exit();
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

        <!-- Mostrar mensaje de éxito si es necesario -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 'player_added'): ?>
            <p class="success-message">Jugador agregado correctamente.</p>
        <?php elseif (isset($_GET['success']) && $_GET['success'] == 'balance_added'): ?>
            <p class="success-message">Saldo agregado correctamente.</p>
        <?php endif; ?>

        <!-- Formulario para agregar un nuevo jugador -->
        <div class="form-container">
            <h2>Agregar Jugador</h2>
            <form action="" method="post">
                <input type="text" name="name" required placeholder="Nombre del Jugador" class="input-field">
                <button type="submit" class="submit-button">Agregar Jugador</button>
            </form>
        </div>

        <!-- Tabla de jugadores -->
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
                        <td><?php echo number_format($player['money'], 2); ?></td>
                        <td>
                            <a href="views/edit_player.php?id=<?php echo $player['id']; ?>" class="action-link">Editar</a>
                            <a href="views/delete_player.php?id=<?php echo $player['id']; ?>" class="action-link">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulario para agregar saldo a un jugador -->
        <div class="form-container">
            <h2>Agregar Saldo a Jugador</h2>
            <form action="" method="post">
                <label for="player_id">Seleccionar Jugador:</label>
                <select name="player_id" id="player_id" required>
                    <?php foreach ($players as $player): ?>
                        <option value="<?php echo $player['id']; ?>">
                            <?php echo htmlspecialchars($player['name']); ?> (Saldo: $<?php echo number_format($player['money'], 2); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <label for="amount">Monto a agregar:</label>
                <input type="number" id="amount" name="amount" min="1" step="0.01" required placeholder="Monto en COP">

                <button type="submit" class="submit-button">Agregar Saldo</button>
            </form>
            <?php if (!empty($message)) : ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <a class="back-button" href="index.php">Ir a apuesta</a>
</body>
</html>
