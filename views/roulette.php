<?php
include '../includes/db.php';
include '../includes/functions.php';

// Asegúrate de que se pasa el ID del jugador
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $player = getPlayerById($id);

    // Verifica si el jugador existe
    if (!$player) {
        echo "Jugador no encontrado.";
        exit;
    }
} else {
    echo "ID de jugador no proporcionado.";
    exit;
}

function spinRoulette($bet, $color) {
    $result = rand(1, 100); // Genera un número entre 1 y 100
    if ($result <= 2) { // Verde
        return 'Verde';
    } elseif ($result <= 51) { // Rojo
        return 'Rojo';
    } else { // Negro
        return 'Negro';
    }
}

// Inicializar variables
$result = ""; // Inicializar la variable $result
$resultMessage = "";
$bet = 0; // Inicializar la variable $bet
$percentage = 0; // Inicializar la variable para el porcentaje
$warningMessage = ""; // Inicializar el mensaje de advertencia
$gainLossMessage = ""; // Inicializar el mensaje de ganancia/pérdida

// Procesar la apuesta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $color = $_POST['color'];
    $money = $player['money'];

    // Verificar si el jugador puede apostar
    if ($money <= 1000) {
        $warningMessage = "No puedes apostar porque tu saldo es de $1000 o menor.";
    } else {
        // Generar una apuesta entre el 8% y el 15% del dinero disponible
        $percentage = rand(8, 15); // Genera un porcentaje entre 8 y 15
        $bet = ($percentage / 100) * $money; // Calcula el monto a apostar basado en el porcentaje

        // Verifica que la apuesta sea válida
        if ($bet > $money) {
            $resultMessage = "No puedes apostar más de lo que tienes.";
        } else {
            $result = spinRoulette($bet, $color);
            if ($result === $color) {
                if ($color === 'Verde') {
                    $money += ($bet * 15); // Ganancia para Verde
                    $gainLossMessage = "Ganaste: $" . number_format($bet * 15, 2);
                } else {
                    $money += ($bet * 2); // Ganancia para Rojo o Negro
                    $gainLossMessage = "Ganaste: $" . number_format($bet * 2, 2);
                }
            } else {
                $money -= $bet; // Pierde la apuesta
                $gainLossMessage = "Perdiste: $" . number_format($bet, 2);
            }
            
            // Actualizar el dinero del jugador en la base de datos
            editPlayer($id, $player['name'], $money);
            $resultMessage = "Tu nuevo saldo es: $" . number_format($money, 2);
            
            // Redirigir si el saldo es 1000 o menor
            if ($money <= 1000) {
                header("Location: ../index.php");
                exit; // Terminar el script después de redirigir
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Apostar en la Ruleta</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Actualiza la ruta aquí -->
</head>
<body>
    <h1>Apostar a la Ruleta</h1>
    <p>Dinero disponible: $<?php echo number_format($player['money'], 2); ?></p>
    
    <form id="betForm" action="roulette.php?id=<?php echo $id; ?>" method="post">
        <input type="hidden" name="bet" value="<?php echo $bet; ?>">
        <select name="color">
            <option value="Verde">Verde</option>
            <option value="Rojo">Rojo</option>
            <option value="Negro">Negro</option>
        </select>
        <button type="submit">Apostar</button>
    </form>

    <div id="roulette">
        <div id="green"></div>
        <div id="red"></div>
        <div id="black"></div>
    </div>

    <div id="result">
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <p>Resultado: <span style="color: <?php echo strtolower($result); ?>"><?php echo $result; ?></span></p>
            <p>Porcentaje apostado: <?php echo $percentage; ?>%</p>
            <?php if (!empty($warningMessage)) : ?>
                <p style="color: red;"><?php echo $warningMessage; ?></p>
            <?php endif; ?>
            <p><?php echo $gainLossMessage; ?></p>
        <?php endif; ?>
    </div>

    <div>
        <p><?php echo $resultMessage; ?></p>
    </div>

    <a class="back-button" href="../index.php">Volver a Inicio</a>

    <script>
        const form = document.getElementById('betForm');
        const roulette = document.getElementById('roulette');

        form.onsubmit = function() {
            roulette.style.transform = 'rotate(' + (Math.random() * 360 + 3600) + 'deg)'; // Genera un giro aleatorio
        };
    </script>
</body>
</html>
