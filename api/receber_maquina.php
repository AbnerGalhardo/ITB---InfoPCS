<?php
require_once "../config/db.php";

// Segurança básica: só aceita POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Método não permitido");
}

// Recebendo dados
$patrimonio = $_POST["patrimonio"] ?? null;
$pc         = $_POST["pc"] ?? null;
$usuario    = $_POST["usuario"] ?? null;
$cpu        = $_POST["cpu"] ?? null;
$ram        = $_POST["ram"] ?? null;
$so         = $_POST["so"] ?? null;
$placa_mae  = $_POST["placa_mae"] ?? null;
$bios       = $_POST["bios"] ?? null;
$arquitetura = $_POST["arquitetura"] ?? null;
$versao_so   = $_POST["versao_so"] ?? null;
$fabricante  = $_POST["fabricante"] ?? null;
$disco       = $_POST["disco"] ?? null;

// Validação mínima
if (!$patrimonio || !$pc) {
    http_response_code(400);
    exit("Dados obrigatórios ausentes");
}

// Verifica se já existe máquina com esse patrimônio
$check = $pdo->prepare("SELECT id FROM maquinas WHERE patrimonio = ?");
$check->execute([$patrimonio]);

if ($check->rowCount() > 0) {
    // Atualiza
    $sql = $pdo->prepare("
        UPDATE maquinas SET
        pc = ?, usuario = ?, cpu = ?, ram = ?, so = ?, placa_mae = ?, bios = ?,
        arquitetura = ?, versao_so = ?, fabricante = ?, disco = ?, data_coleta = NOW()
        WHERE patrimonio = ?
    ");
    $sql->execute([
    $pc, $usuario, $cpu, $ram, $so, $placa_mae, $bios,
    $arquitetura, $versao_so, $fabricante, $disco,
    $patrimonio
]);

} else {
    // Insere
    $sql = $pdo->prepare("
        INSERT INTO maquinas
        (patrimonio, pc, usuario, cpu, ram, so, placa_mae, bios, arquitetura, versao_so, fabricante, disco, data_coleta)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())

    ");
    $sql->execute([
    $patrimonio, $pc, $usuario, $cpu, $ram, $so,
    $placa_mae, $bios, $arquitetura, $versao_so, $fabricante, $disco
]);

}
