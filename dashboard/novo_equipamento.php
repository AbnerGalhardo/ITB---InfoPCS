<?php
session_start();
require_once "../config/db.php";
require_once "../config/auth.php";

$msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$nome = $_POST["nome"] ?? "";
$ip = $_POST["ip"] ?? "";
$tipo = $_POST["tipo"] ?? "";
$local = $_POST["local"] ?? "";
$usuario = $_POST["usuario"] ?? "";
$senha = $_POST["senha"] ?? "";
$obs = $_POST["obs"] ?? "";

$sql = "INSERT INTO equipamentos_rede
(nome,ip,tipo,local,usuario,senha,observacoes)
VALUES (?,?,?,?,?,?,?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([$nome,$ip,$tipo,$local,$usuario,$senha,$obs]);

$msg = "Equipamento cadastrado!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Novo Equipamento</title>

<style>

body{
background:linear-gradient(135deg,#1e1e1e,#121212);
font-family:Arial;
color:#fff;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.box{
background:#2a2a2a;
padding:40px;
border-radius:10px;
width:420px;
box-shadow:0 0 20px rgba(0,0,0,0.5);
}

h2{
color:#ff9800;
margin-bottom:20px;
}

input,select,textarea{
width:100%;
padding:12px;
margin-bottom:15px;
border:none;
border-radius:6px;
background:#1f1f1f;
color:#fff;
}

input:focus,select:focus,textarea:focus{
outline:none;
border:1px solid #ff9800;
}

button{
width:100%;
padding:12px;
border:none;
border-radius:6px;
background:#ff9800;
font-weight:bold;
cursor:pointer;
}

button:hover{
background:#fb8c00;
}

.msg{
background:#2e7d32;
padding:10px;
border-radius:6px;
margin-bottom:15px;
}

.voltar{
display:inline-block;
margin-top:15px;
color:#ff9800;
text-decoration:none;
}

</style>
</head>

<body>

<div class="box">

<h2>📡 Novo DVR / Switch</h2>

<?php if($msg): ?>
<div class="msg"><?= $msg ?></div>
<?php endif; ?>

<form method="POST">

<input type="text" name="nome" placeholder="Nome do Equipamento" required>

<select name="tipo" required>
<option value="">Tipo</option>
<option>DVR</option>
<option>Switch</option>
</select>

<input type="text" name="ip" placeholder="IP">

<input type="text" name="local" placeholder="Local / Setor">

<input type="text" name="usuario" placeholder="Usuário">

<input type="text" name="senha" placeholder="Senha">

<textarea name="obs" placeholder="Observações"></textarea>

<button type="submit">Salvar Equipamento</button>

</form>

<a class="voltar" href="dvrs_switch.php">← Voltar</a>

</div>

</body>
</html>