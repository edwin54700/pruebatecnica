<?php
include 'db.php';

// Agregar un jugador
function addPlayer($name) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO players (name, money) VALUES (:name, 10000)");
    $stmt->execute(['name' => $name]);
}

// Obtener todos los jugadores
function getPlayers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM players");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener un jugador por ID
function getPlayerById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM players WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Editar un jugador (actualizar su saldo y nombre)
function editPlayer($id, $name, $money) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE players SET name = :name, money = :money WHERE id = :id");
    $stmt->execute(['name' => $name, 'money' => $money, 'id' => $id]);
}

// Eliminar un jugador
function deletePlayer($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM players WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

// Agregar saldo a un jugador
function addBalanceToPlayer($id, $amount) {
    global $pdo;
    
    if ($amount <= 0) {
        return "El monto debe ser mayor que 0.";
    }
    
    $player = getPlayerById($id);
    if (!$player) {
        return "Jugador no encontrado.";
    }

    $newBalance = $player['money'] + $amount;

    $stmt = $pdo->prepare("UPDATE players SET money = :money WHERE id = :id");
    $stmt->execute(['money' => $newBalance, 'id' => $id]);

    return "El saldo ha sido actualizado. Nuevo saldo: $" . number_format($newBalance, 2);
}


?>

