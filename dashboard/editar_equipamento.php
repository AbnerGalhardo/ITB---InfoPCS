<?php
session_start();
require_once "../config/db.php";
require_once "../config/auth.php";

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM equipamentos_rede WHERE id = ?");
$stmt->execute([$id]);
$eq = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$eq){
die("Equipamento não encontrado");
}

$msg = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$tipo = $_POST['tipo'];
$modelo = $_POST['modelo'];
$ip = $_POST['ip'];
$setor = $_POST['setor'];
$observacao = $_POST['observacao'];

$sql = "UPDATE equipamentos_rede SET
tipo = :tipo,
modelo = :modelo,
ip = :ip,
setor = :setor,
observacao = :observacao
WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
":tipo"=>$tipo,
":modelo"=>$modelo,
":ip"=>$ip,
":setor"=>$setor,
":observacao"=>$observacao,
":id"=>$id
]);

$msg = "Equipamento atualizado";

$stmt = $pdo->prepare("SELECT * FROM equipamentos_rede WHERE id = ?");
$stmt->execute([$id]);
$eq = $stmt->fetch(PDO::FETCH_ASSOC);

}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Equipamento</title>

<style>

body{
background:#0f1115;
font-family:Arial;
color:#fff;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.box{
background:#1a1c22;
padding:40px;
border-radius:10px;
width:420px;
}

h2{
color:#ff9800;
margin-bottom:20px;
}

input,select,textarea{
width:100%;
padding:10px;
margin-bottom:12px;
border:none;
border-radius:6px;
background:#2a2f3a;
color:#fff;
}

button{
width:100%;
padding:12px;
background:#ff9800;
border:none;
border-radius:6px;
font-weight:bold;
cursor:pointer;
}

.msg{
background:#2e7d32;
padding:10px;
border-radius:6px;
margin-bottom:10px;
}

</style>
</head>

<body>

<div class="box">

<h2>Editar DVR / Switch</h2>

<?php if($msg): ?>
<div class="msg"><?= $msg ?></div>
<?php endif; ?>

<form method="POST">

<select name="tipo">
<option <?= $eq['tipo']=="DVR"?"selected":"" ?>>DVR</option>
<option <?= $eq['tipo']=="Switch"?"selected":"" ?>>Switch</option>
</select>

<input type="text" name="modelo" value="<?= $eq['modelo'] ?>">

<input type="text" name="ip" value="<?= $eq['ip'] ?>">

<input type="text" name="setor" value="<?= $eq['setor'] ?>">

<textarea name="observacao"><?= $eq['observacao'] ?></textarea>

<button type="submit">Salvar Alterações</button>

</form>

</div>

</body>
</html>