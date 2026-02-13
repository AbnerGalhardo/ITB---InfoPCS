<?php
include_once __DIR__ . '/../config/db.php';

$busca = $_GET['busca'] ?? '';
$setor = $_GET['setor'] ?? '';

$sql = "SELECT * FROM maquinas WHERE 1=1";
$params = [];

if (!empty($busca)) {
    $sql .= " AND (patrimonio LIKE :busca OR pc LIKE :busca)";
    $params[':busca'] = "%$busca%";
}

if (!empty($setor)) {
    $sql .= " AND setor = :setor";
    $params[':setor'] = $setor;
}

$sql .= " ORDER BY pc ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$pcs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$setoresStmt = $pdo->query("SELECT DISTINCT setor FROM maquinas ORDER BY setor");
$setores = $setoresStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Dashboard - InfoPCS</title>

<style>
body {
    background: #0f1115;
    font-family: Arial, sans-serif;
    color: #fff;
    margin: 0;
}

.topbar {
    background: #151821;
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.topbar h1 {
    margin: 0;
    font-size: 22px;
    color: #4db8ff;
}

.btn-add {
    background: #00c853;
    padding: 8px 15px;
    border-radius: 6px;
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    transition: 0.2s;
}

.btn-add:hover {
    background: #00e676;
    box-shadow: 0 0 10px rgba(0, 230, 118, 0.6);
}

.container {
    padding: 30px 40px;
}

.filtros {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

input, select {
    padding: 8px 12px;
    border-radius: 6px;
    border: none;
    background: #1f222b;
    color: #fff;
}

button {
    padding: 8px 15px;
    border-radius: 6px;
    border: none;
    background: #4db8ff;
    cursor: pointer;
    font-weight: bold;
}

button:hover {
    opacity: 0.9;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.card {
    background: #1a1c22;
    padding: 20px;
    border-radius: 12px;
    transition: 0.2s;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0 15px rgba(77,184,255,0.3);
}

.card h3 {
    margin-top: 0;
    color: #4db8ff;
}

.card p {
    margin: 6px 0;
    font-size: 14px;
}

.card a {
    display: inline-block;
    margin-top: 10px;
    color: #4db8ff;
    text-decoration: none;
    font-weight: bold;
}

.badge {
    display: inline-block;
    padding: 3px 8px;
    background: #2a2f3a;
    border-radius: 5px;
    font-size: 12px;
}
</style>
</head>
<body>

<div class="topbar">
    <h1>InfoPCS - Dashboard</h1>
    <a href="upload_cpuz.php" class="btn-add">+ Importar CPUZ</a>
</div>

<div class="container">

<form method="GET" class="filtros">

    <input type="text" name="busca"
        placeholder="Buscar por patrimônio ou nome"
        value="<?= htmlspecialchars($busca) ?>">

    <select name="setor">
        <option value="">Todos os setores</option>
        <?php foreach ($setores as $s): ?>
            <option value="<?= htmlspecialchars($s) ?>"
                <?= ($setor == $s) ? 'selected' : '' ?>>
                <?= htmlspecialchars($s) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Filtrar</button>

</form>

<div class="grid">

<?php if (count($pcs) > 0): ?>
    <?php foreach ($pcs as $pc): ?>
        <div class="card">
            <h3><?= htmlspecialchars($pc['pc']) ?></h3>
            <p><strong>Patrimônio:</strong> <?= htmlspecialchars($pc['patrimonio']) ?></p>
            <p><strong>Usuário:</strong> <?= htmlspecialchars($pc['usuario']) ?></p>
            <p><strong>Setor:</strong>
                <span class="badge"><?= htmlspecialchars($pc['setor']) ?></span>
            </p>
            <a href="detalhes.php?patrimonio=<?= urlencode($pc['patrimonio']) ?>">
                Ver detalhes →
            </a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Nenhuma máquina encontrada.</p>
<?php endif; ?>

</div>

</div>

</body>
</html>
