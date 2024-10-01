<?php
include_once 'includes/db.php'; // Incluir la conexión PDO
include_once 'includes/functions.php'; // Incluir funciones

$players = getPlayers(); // Obtener todos los jugadores

// Función para simular el giro de la ruleta
function spinRoulette() {
    // Definir las probabilidades
    $random = rand(1, 100); // Generar un número aleatorio entre 1 y 100

    // Determinar el color basado en las probabilidades
    if ($random <= 2) {
        return 'Verde'; // 2% de probabilidad
    } elseif ($random <= 51) {
        return 'Rojo'; // 49% de probabilidad
    } else {
        return 'Negro'; // 49% de probabilidad
    }
}

// Simular el giro de la ruleta una vez
$result = spinRoulette(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Apuesta Automática para Todos los Jugadores</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Asegúrate de que la ruta del CSS sea correcta -->
    <link rel="stylesheet" href="css/style_roulette.css"> <!-- Asegúrate de que la ruta del CSS para la ruleta sea correcta -->
</head>
<body>
    <h1>Resultados de la Ruleta para Todos los Jugadores</h1>

    <div class="roulette" id="roulette">
        <div class="arrow"></div> <!-- Flecha que señala el resultado -->
    </div>

    <div class="result" id="roulette-result"></div>

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Dinero Inicial</th>
                <th>Porcentaje Apostado</th>
                <th>Apuesta</th>
                <th>Color Apostado</th>
                <th>Resultado</th>
                <th>Ganancia/Pérdida</th>
                <th>Dinero Final</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($players as $player): ?>
                <?php
                    // Inicializar variables para la apuesta
                    $initialMoney = $player['money'];

                    // Verificar si el jugador tiene saldo para apostar
                    if ($initialMoney <= 1000) {
                        echo "<tr>
                                <td>" . htmlspecialchars($player['name']) . "</td>
                                <td>$" . number_format($initialMoney, 2) . "</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>No puede apostar, recargue saldo</td>
                                <td>-</td>
                                <td>$" . number_format($initialMoney, 2) . "</td>
                              </tr>";
                        continue; // Pasar al siguiente jugador
                    }

                    $percentage = rand(8, 15); // Apuesta entre el 8% y 15%
                    $bet = ($percentage / 100) * $initialMoney;

                    // Asignar un color aleatorio basado en las probabilidades
                    $color = '';
                    $random = rand(1, 100); // Generar un número aleatorio entre 1 y 100
                    if ($random <= 2) {
                        $color = 'Verde'; // 2% de probabilidad
                    } elseif ($random <= 51) {
                        $color = 'Rojo'; // 49% de probabilidad
                    } else {
                        $color = 'Negro'; // 49% de probabilidad
                    }

                    // Usar el resultado de la ruleta para calcular ganancias/pérdidas
                    $gainOrLoss = 0; // Inicializar ganancia/pérdida
                    if ($result === $color) {
                        if ($color === 'Verde') {
                            $gainOrLoss = $bet * 15; // Ganancia para Verde
                        } else {
                            $gainOrLoss = $bet * 2; // Ganancia para Rojo o Negro
                        }
                    } else {
                        $gainOrLoss = -$bet; // Pérdida de la apuesta
                    }
                    $finalMoney = $initialMoney + $gainOrLoss; // Dinero final del jugador

                    // Actualizar el saldo del jugador en la base de datos
                    editPlayer($player['id'], $player['name'], $finalMoney);
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($player['name']); ?></td>
                    <td>$<?php echo number_format($initialMoney, 2); ?></td>
                    <td><?php echo $percentage; ?>%</td>
                    <td>$<?php echo number_format($bet, 2); ?></td>
                    <td><?php echo $color; ?></td>
                    <td><?php echo $result; ?></td>
                    <td>$<?php echo number_format($gainOrLoss, 2); ?></td>
                    <td>$<?php echo number_format($finalMoney, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a class="back-button" href="gestion.php">Gestionar jugadores</a>

    <script>
        // Mostrar el resultado de la ruleta
        const resultDiv = document.getElementById('roulette-result');
        const finalResult = "<?php echo $result; ?>"; // Obtener el resultado final de PHP
        resultDiv.innerText = "Resultado de la Ruleta: " + finalResult;
    </script>
</body>
</html>

