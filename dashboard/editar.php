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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$usuario = $_POST['usuario'] ?? '';
$setor = $_POST['setor'] ?? '';
$ip = $_POST['ip'] ?? '';

$so = $_POST['so'] ?? '';
$arquitetura = $_POST['arquitetura'] ?? '';
$versao_so = $_POST['versao_so'] ?? '';
$fabricante = $_POST['fabricante'] ?? '';

$cpu = $_POST['cpu'] ?? '';
$ram = $_POST['ram'] ?? '';
$placa_mae = $_POST['placa_mae'] ?? '';
$bios = $_POST['bios'] ?? '';
$disco = $_POST['disco'] ?? '';

$possui_vm = $_POST['possui_vm'] ?? 'Não';
$nome_vm = $_POST['nome_vm'] ?? '';
$ip_vm = $_POST['ip_vm'] ?? '';

$manut_realizada = $_POST['manutencao_realizada'] ?? null;

$manut_prevista = null;
if ($manut_realizada) {
    $manut_prevista = date('Y-m-d', strtotime($manut_realizada . ' +6 months'));
}

$sql = "UPDATE maquinas SET
usuario=:usuario,
setor=:setor,
ip=:ip,
so=:so,
arquitetura=:arquitetura,
versao_so=:versao_so,
fabricante=:fabricante,
cpu=:cpu,
ram=:ram,
placa_mae=:placa_mae,
bios=:bios,
disco=:disco,
possui_vm=:possui_vm,
nome_vm=:nome_vm,
ip_vm=:ip_vm,
manutencao_realizada=:manut_realizada,
manutencao_prevista=:manut_prevista
WHERE patrimonio=:patrimonio";

$stmt = $pdo->prepare($sql);

$stmt->execute([
':usuario'=>$usuario,
':setor'=>$setor,
':ip'=>$ip,
':so'=>$so,
':arquitetura'=>$arquitetura,
':versao_so'=>$versao_so,
':fabricante'=>$fabricante,
':cpu'=>$cpu,
':ram'=>$ram,
':placa_mae'=>$placa_mae,
':bios'=>$bios,
':disco'=>$disco,
':possui_vm'=>$possui_vm,
':nome_vm'=>$nome_vm,
':ip_vm'=>$ip_vm,
':manut_realizada'=>$manut_realizada,
':manut_prevista'=>$manut_prevista,
':patrimonio'=>$patrimonio
]);

header("Location: detalhes.php?patrimonio=".$patrimonio);
exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar PC</title>

<style>

body{
background:#0f1115;
font-family:Arial;
color:white;
margin:0;
}

.container{
padding:40px;
}

h1{
margin-bottom:30px;
}

a{
color:#4db8ff;
text-decoration:none;
}

.grid{
display:grid;
grid-template-columns:repeat(4,minmax(260px,1fr));
gap:20px;
}

.card{
background:#1a1c22;
padding:20px;
border-radius:10px;
}

.card h3{
color:#4db8ff;
margin-top:0;
}

label{
display:block;
margin-top:10px;
font-size:14px;
}

input,select{
width:100%;
padding:9px;
margin-top:5px;
background:#0f1115;
border:1px solid #333;
border-radius:6px;
color:white;
box-sizing:border-box;
}

button{
margin-top:30px;
padding:12px 25px;
background:#4db8ff;
border:none;
border-radius:8px;
font-size:16px;
cursor:pointer;
}

.vm_fields{
display:none;
}

</style>

<script>

function toggleVM(){
let select=document.getElementById("possui_vm").value;
let vm=document.getElementById("vm_fields");

if(select==="Sim"){
vm.style.display="block";
}else{
vm.style.display="none";
}
}

function calcularManutencao(){
let realizada=document.getElementById("manut_realizada").value;

if(realizada){

let data=new Date(realizada);
data.setMonth(data.getMonth()+6);

let ano=data.getFullYear();
let mes=('0'+(data.getMonth()+1)).slice(-2);
let dia=('0'+data.getDate()).slice(-2);

document.getElementById("manut_prevista").value=ano+"-"+mes+"-"+dia;
}
}

</script>

</head>

<body>

<div class="container">

<a href="detalhes.php?patrimonio=<?php echo $pc['patrimonio']; ?>">← Voltar</a>

<h1>Editar PC: <?php echo htmlspecialchars($pc['pc']); ?></h1>

<form method="POST">

<div class="grid">

<div class="card">

<h3>Informações</h3>

<label>Usuário</label>
<input type="text" name="usuario" value="<?=htmlspecialchars($pc['usuario'])?>">

<label>Setor</label>
<input type="text" name="setor" value="<?=htmlspecialchars($pc['setor'])?>">

<label>IP</label>
<input type="text" name="ip" value="<?=htmlspecialchars($pc['ip'])?>">

<label>Possui VM?</label>
<select name="possui_vm" id="possui_vm" onchange="toggleVM()">
<option value="Não" <?=$pc['possui_vm']=="Não"?'selected':''?>>Não</option>
<option value="Sim" <?=$pc['possui_vm']=="Sim"?'selected':''?>>Sim</option>
</select>

<div id="vm_fields" class="vm_fields">

<label>Nome da VM</label>
<input type="text" name="nome_vm" value="<?=htmlspecialchars($pc['nome_vm'])?>">

<label>IP da VM</label>
<input type="text" name="ip_vm" value="<?=htmlspecialchars($pc['ip_vm'])?>">

</div>

</div>

<div class="card">

<h3>Sistema</h3>

<label>Sistema Operacional</label>
<input type="text" name="so" value="<?=htmlspecialchars($pc['so'])?>">

<label>Arquitetura</label>
<input type="text" name="arquitetura" value="<?=htmlspecialchars($pc['arquitetura'])?>">

<label>Versão</label>
<input type="text" name="versao_so" value="<?=htmlspecialchars($pc['versao_so'])?>">

<label>Fabricante</label>
<input type="text" name="fabricante" value="<?=htmlspecialchars($pc['fabricante'])?>">

</div>

<div class="card">

<h3>Hardware</h3>

<label>Processador</label>
<input type="text" name="cpu" value="<?=htmlspecialchars($pc['cpu'])?>">

<label>Memória</label>
<input type="text" name="ram" value="<?=htmlspecialchars($pc['ram'])?>">

<label>Placa-mãe</label>
<input type="text" name="placa_mae" value="<?=htmlspecialchars($pc['placa_mae'])?>">

<label>BIOS</label>
<input type="text" name="bios" value="<?=htmlspecialchars($pc['bios'])?>">

<label>Disco</label>
<input type="text" name="disco" value="<?=htmlspecialchars($pc['disco'])?>">

</div>

<div class="card">

<h3>Manutenção</h3>

<label>Manutenção realizada</label>
<input type="date" id="manut_realizada" name="manutencao_realizada"
value="<?=$pc['manutencao_realizada']?>"
onchange="calcularManutencao()">

<label>Manutenção prevista</label>
<input type="date" id="manut_prevista"
value="<?=$pc['manutencao_prevista']?>">

</div>

</div>

<button type="submit">Salvar Alterações</button>

</form>

</div>

<script>
toggleVM();
</script>

</body>
</html>