<?php
session_start();
require_once "../config/db.php";
require_once "../config/auth.php";

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM impressoras WHERE id = ?");
$stmt->execute([$id]);
$imp = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$imp){
die("Impressora não encontrada");
}

$msg = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$patrimonio = $_POST['patrimonio'];
$modelo = $_POST['modelo'];
$ip = $_POST['ip'];
$setor = $_POST['setor'];
$observacao = $_POST['observacao'];

$sql = "UPDATE impressoras SET
patrimonio = :patrimonio,
modelo = :modelo,
ip = :ip,
setor = :setor,
observacao = :observacao
WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
":patrimonio"=>$patrimonio,
":modelo"=>$modelo,
":ip"=>$ip,
":setor"=>$setor,
":observacao"=>$observacao,
":id"=>$id
]);

$msg = "Impressora atualizada com sucesso";

$stmt = $pdo->prepare("SELECT * FROM impressoras WHERE id = ?");
$stmt->execute([$id]);
$imp = $stmt->fetch(PDO::FETCH_ASSOC);

}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Impressora</title>

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
color:#4db8ff;
margin-bottom:20px;
}

input,textarea{
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
background:#4db8ff;
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

<h2>Editar Impressora</h2>

<?php if($msg): ?>
<div class="msg"><?= $msg ?></div>
<?php endif; ?>

<form method="POST">

<input type="text" name="patrimonio" value="<?= $imp['patrimonio'] ?>">

<input type="text" name="modelo" value="<?= $imp['modelo'] ?>">

<input type="text" name="ip" value="<?= $imp['ip'] ?>">

<input type="text" name="setor" value="<?= $imp['setor'] ?>">

<textarea name="observacao"><?= $imp['observacao'] ?></textarea>

<button type="submit">Salvar Alterações</button>

</form>

</div>

</body>
</html>