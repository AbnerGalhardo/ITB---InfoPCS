<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../config/db.php";

$sql = $pdo->query("SELECT * FROM maquinas ORDER BY data_coleta DESC");
$maquinas = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<link rel="shortcut icon" href="logo.png" type="image/x-icon">
<head>
    <meta charset="UTF-8">
    <title>Máquinas - InfoPCS</title>
    <style>
        body {
            background: #1e1e1e;
            color: #fff;
            font-family: Arial;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #333;
            text-align: left;
        }
        th {
            background: #2a2a2a;
        }
        tr:hover {
            background: #2f2f2f;
        }
        a {
            color: #4fc3f7;
            text-decoration: none;
        }
    </style>
</head>
<body>
<a href="upload_cpuz.php">+ Importar CPU-Z</a>
<h2>Máquinas cadastradas</h2>

<table>
    <tr>
        <th>Patrimônio</th>
        <th>PC</th>
        <th>Usuário</th>
        <th>SO</th>
        <th>Última coleta</th>
        <th>Ação</th>
    </tr>

    <?php foreach ($maquinas as $m): ?>
    <tr>
        <td><?= htmlspecialchars($m["patrimonio"]) ?></td>
        <td><?= htmlspecialchars($m["pc"]) ?></td>
        <td><?= htmlspecialchars($m["usuario"]) ?></td>
        <td><?= htmlspecialchars($m["so"]) ?></td>
        <td><?= htmlspecialchars($m["data_coleta"]) ?></td>
        <td>
            <a href="detalhes.php?patrimonio=<?= $m["patrimonio"] ?>">
                Ver detalhes
            </a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
