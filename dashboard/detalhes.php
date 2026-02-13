<?php
include_once __DIR__ . '/../config/db.php';

if (!isset($_GET['patrimonio'])) {
    header("Location: index.php");
    exit;
}

$patrimonio = $_GET['patrimonio'];

$stmt = $pdo->prepare("SELECT * FROM maquinas WHERE patrimonio = :patrimonio");
$stmt->bindParam(':patrimonio', $patrimonio);
$stmt->execute();

$pc = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pc) {
    echo "PC não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Detalhes do PC</title>

<style>
body {
    background: #0f1115;
    font-family: Arial, sans-serif;
    color: #fff;
    margin: 0;
}
.container {
    padding: 40px;
}
a {
    color: #4db8ff;
    text-decoration: none;
}
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}
.card {
    background: #1a1c22;
    padding: 20px;
    border-radius: 10px;
}
.card h3 {
    color: #4db8ff;
    margin-top: 0;
}
</style>
</head>
<body>

<div class="container">

<a href="index.php">← Voltar</a>

<h1>PC: <?= htmlspecialchars($pc['pc']) ?></h1>

<p><strong>Patrimônio:</strong> <?= htmlspecialchars($pc['patrimonio']) ?></p>
<p><strong>Usuário:</strong> <?= htmlspecialchars($pc['usuario']) ?></p>
<p><strong>Setor:</strong> <?= htmlspecialchars($pc['setor']) ?></p>

<div class="grid">

<div class="card">
    <h3>Sistema</h3>
    <p><strong>SO:</strong> <?= htmlspecialchars($pc['so']) ?></p>
    <p><strong>Arquitetura:</strong> <?= htmlspecialchars($pc['arquitetura']) ?></p>
    <p><strong>Versão:</strong> <?= htmlspecialchars($pc['versao_so']) ?></p>
    <p><strong>Fabricante:</strong> <?= htmlspecialchars($pc['fabricante']) ?></p>
</div>

<div class="card">
    <h3>Processador</h3>
    <p><?= htmlspecialchars($pc['cpu']) ?></p>
</div>

<div class="card">
    <h3>Memória</h3>
    <p><?= htmlspecialchars($pc['ram']) ?></p>
</div>

<div class="card">
    <h3>Placa-mãe</h3>
    <p><?= htmlspecialchars($pc['placa_mae']) ?></p>
</div>

<div class="card">
    <h3>BIOS</h3>
    <p><?= htmlspecialchars($pc['bios']) ?></p>
</div>

<div class="card">
    <h3>Disco</h3>
    <p><?= htmlspecialchars($pc['disco']) ?></p>
</div>

</div>
</div>
</body>
</html>
