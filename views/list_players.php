<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Dinero</th>
        <th>Acciones</th>
    </tr>
    <?php foreach (getPlayers() as $player): ?>
    <tr>
        <td><?php echo $player['id']; ?></td>
        <td><?php echo $player['name']; ?></td>
        <td><?php echo $player['money']; ?></td>
        <td>
            <a href="edit_player.php?id=<?php echo $player['id']; ?>">Editar</a>
            <a href="delete_player.php?id=<?php echo $player['id']; ?>">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
