<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../config/db.php";

if (!isset($_GET["patrimonio"])) {
    die("Patrimônio não informado.");
}

$patrimonio = $_GET["patrimonio"];

$stmt = $pdo->prepare("SELECT * FROM maquinas WHERE patrimonio = ?");
$stmt->execute([$patrimonio]);
$maquina = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$maquina) {
    die("Máquina não encontrada.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<link rel="shortcut icon" href="logo.png" type="image/x-icon">
<head>
    <meta charset="UTF-8">
    <title>Detalhes - <?= htmlspecialchars($maquina["pc"]) ?></title>
    <style>
        body {
            background: #1e1e1e;
            color: #fff;
            font-family: Arial;
        }
        .container {
            max-width: 1100px;
            margin: auto;
        }
        h2 {
            margin-top: 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .card {
            background: #2a2a2a;
            padding: 15px;
            border-radius: 8px;
        }
        .card h3 {
            margin-top: 0;
            color: #4fc3f7;
        }
        .voltar {
            display: inline-block;
            margin-top: 15px;
            color: #4fc3f7;
        }
    </style>
</head>
<body>

<div class="container">
    <a class="voltar" href="maquinas.php">← Voltar</a>

    <h2>PC: <?= htmlspecialchars($maquina["pc"]) ?></h2>
    <p><strong>Patrimônio:</strong> <?= htmlspecialchars($maquina["patrimonio"]) ?></p>
    <p><strong>Usuário:</strong> <?= htmlspecialchars($maquina["usuario"]) ?></p>

    <div class="grid">

        <div class="card">
            <h3>Sistema</h3>
            <p><strong>SO:</strong> <?= htmlspecialchars($maquina["so"]) ?></p>
            <p><strong>Arquitetura:</strong> <?= htmlspecialchars($maquina["arquitetura"]) ?></p>
            <p><strong>Versão:</strong> <?= htmlspecialchars($maquina["versao_so"]) ?></p>
            <p><strong>Fabricante:</strong> <?= htmlspecialchars($maquina["fabricante"]) ?></p>
        </div>

        <div class="card">
            <h3>Processador</h3>
            <p><?= htmlspecialchars($maquina["cpu"]) ?></p>
        </div>

        <div class="card">
            <h3>Memória</h3>
            <p><?= htmlspecialchars($maquina["ram"]) ?> GB</p>
        </div>

        <div class="card">
            <h3>Placa-mãe</h3>
            <p><?= htmlspecialchars($maquina["placa_mae"]) ?></p>
        </div>

        <div class="card">
            <h3>BIOS</h3>
            <p><?= htmlspecialchars($maquina["bios"]) ?></p>
        </div>

        <div class="card">
            <h3>Disco</h3>
            <p><?= htmlspecialchars($maquina["disco"]) ?></p>
        </div>

    </div>
</div>

</body>
</html>
