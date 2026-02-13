<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: ../login.php");
    exit;
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["arquivo"])) {

    $conteudo = file_get_contents($_FILES["arquivo"]["tmp_name"]);

    // ==============================
    // EXTRAÇÃO DE DADOS DO CPU-Z
    // ==============================

    // PROCESSADOR
    preg_match('/Processor[\s\S]+?Name\s+(.+)/', $conteudo, $cpu);

    // MEMÓRIA
    preg_match('/Memory[\s\S]+?Size\s+(\d+)\s+MBytes/', $conteudo, $ram);

    // SISTEMA OPERACIONAL + ARQUITETURA
    preg_match('/Operating System\s+(.+)\((\d+)-bit\)/', $conteudo, $so);

    // VERSÃO DO WINDOWS
    preg_match('/Version\s+([\d\.]+)/', $conteudo, $versao);

    // PLACA-MÃE
    preg_match('/Mainboard[\s\S]+?Model\s+(.+)/', $conteudo, $placa);

    // BIOS
    preg_match('/BIOS[\s\S]+?Version\s+(.+)/', $conteudo, $bios);

    // DISCO
    preg_match('/Drive[\s\S]+?Model\s+(.+)/', $conteudo, $disco_modelo);
    preg_match('/Drive[\s\S]+?Capacity\s+(.+)/', $conteudo, $disco_cap);

    // ==============================
    // ORGANIZAÇÃO DOS DADOS
    // ==============================

    $processador = $cpu[1] ?? "Não identificado";

    $memoria = isset($ram[1])
        ? round($ram[1] / 1024) . " GB"
        : "Não identificado";

    $sistema = $so[1] ?? "Não identificado";
    $arquitetura = isset($so[2]) ? $so[2] . " bits" : "";

    $versao_so = $versao[1] ?? "";

    $placa_mae = $placa[1] ?? "Não identificado";

    $bios_versao = $bios[1] ?? "Não identificado";

    $disco = isset($disco_modelo[1]) && isset($disco_cap[1])
        ? $disco_modelo[1] . " - " . $disco_cap[1]
        : "Não identificado";

    // ==============================
    // DADOS DO FORMULÁRIO
    // ==============================

    $nome       = $_POST["nome"];
    $patrimonio = $_POST["patrimonio"];
    $setor      = $_POST["setor"];

    // ==============================
    // INSERIR NO BANCO
    // ==============================

    $stmt = $pdo->prepare("INSERT INTO maquinas 
    (pc, patrimonio, cpu, ram, so, arquitetura, versao_so, placa_mae, bios, disco, setor)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $nome,
        $patrimonio,
        $processador,
        $memoria,
        $sistema,
        $arquitetura,
        $versao_so,
        $placa_mae,
        $bios_versao,
        $disco,
        $setor
    ]);

    $mensagem = "Máquina cadastrada com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Importar CPU-Z</title>

<style>
body {
    background: linear-gradient(135deg, #1e1e1e, #121212);
    font-family: Arial;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.box {
    background: #2a2a2a;
    padding: 40px;
    border-radius: 12px;
    width: 420px;
    box-shadow: 0 0 25px rgba(0,0,0,0.5);
    text-align: center;
}

.logo {
    width: 120px;
    margin-bottom: 15px;
}

h2 {
    margin-bottom: 20px;
    color: #4fc3f7;
}

input, select {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: none;
    background: #1f1f1f;
    color: #fff;
}

input:focus, select:focus {
    outline: none;
    border: 1px solid #4fc3f7;
}

button {
    width: 100%;
    padding: 12px;
    background: #4fc3f7;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

button:hover {
    background: #29b6f6;
}

.msg {
    background: #2e7d32;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

.voltar {
    display: inline-block;
    margin-top: 15px;
    color: #4fc3f7;
    text-decoration: none;
}
</style>
</head>

<body>

<div class="box">

    <img src="../img/logo.png" class="logo">

    <h2>Importar CPU-Z</h2>

    <?php if ($mensagem): ?>
        <div class="msg"><?= $mensagem ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="arquivo" required>
        <input type="text" name="nome" placeholder="Nome do Computador" required>
        <input type="text" name="patrimonio" placeholder="Patrimônio" required>

        <select name="setor" required>
            <option value="">Selecione o Setor</option>
            <option>administrativo/superior</option>
            <option>administrativo/inferior</option>
            <option>segurança do trabalho</option>
            <option>RH</option>
            <option>TI</option>
            <option>bobinamento</option>
            <option>qualidade</option>
            <option>manutenção/daliez</option>
            <option>ttr</option>
            <option>silício</option>
            <option>almoxarifado/principal</option>
            <option>almoxarifado/expedição</option>
            <option>placas</option>
            <option>montagem final</option>
            <option>rt</option>
            <option>pintura</option>
            <option>soldagem</option>
            <option>laser</option>
            <option>trafo a seco</option>
            <option>laboratório/qualidade</option>
        </select>

        <button type="submit">Salvar Máquina</button>
    </form>

    <a class="voltar" href="index.php">← Voltar</a>

</div>

</body>
</html>
