<?php
session_start();
require_once "../config/db.php";
require_once "../config/auth.php";

$msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$nome = $_POST["nome"] ?? "";
$ip = $_POST["ip"] ?? "";
$setor = $_POST["setor"] ?? "";
$modelo = $_POST["modelo"] ?? "";
$obs = $_POST["obs"] ?? "";

$sql = "INSERT INTO impressoras (nome,ip,setor,modelo,observacoes)
VALUES (?,?,?,?,?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([$nome,$ip,$setor,$modelo,$obs]);

$msg = "Impressora cadastrada com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Nova Impressora</title>

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
color:#4fc3f7;
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
border:1px solid #4fc3f7;
}

button{
width:100%;
padding:12px;
border:none;
border-radius:6px;
background:#4fc3f7;
font-weight:bold;
cursor:pointer;
}

button:hover{
background:#29b6f6;
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
color:#4fc3f7;
text-decoration:none;
}

</style>
</head>

<body>

<div class="box">

<h2>🖨 Nova Impressora</h2>

<?php if($msg): ?>
<div class="msg"><?= $msg ?></div>
<?php endif; ?>

<form method="POST">

<input type="text" name="nome" placeholder="Nome da Impressora" required>

<input type="text" name="ip" placeholder="IP da Impressora">

<input type="text" name="modelo" placeholder="Modelo">

<input type="text" name="setor" placeholder="Setor">

<textarea name="obs" placeholder="Observações"></textarea>

<button type="submit">Salvar Impressora</button>

</form>

<a class="voltar" href="impressoras.php">← Voltar</a>

</div>

</body>
</html>