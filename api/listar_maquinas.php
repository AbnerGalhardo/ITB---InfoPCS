<?php
require_once "../config/auth.php";
require_once "../config/db.php";

$sql = $pdo->query("SELECT * FROM maquinas ORDER BY data_coleta DESC");
$dados = $sql->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($dados);
echo "</pre>";
