<?php
include("conexao.php");

$sql = "SELECT * FROM equipamentos_rede";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>DVRs e Switchs</title>

<style>

body{
font-family:Arial;
background:#f5f5f5;
padding:20px;
}

h1{
margin-bottom:20px;
}

table{
width:100%;
border-collapse:collapse;
background:white;
}

th,td{
padding:10px;
border:1px solid #ddd;
text-align:left;
}

th{
background:#333;
color:white;
}

.voltar{
display:inline-block;
margin-bottom:20px;
background:#007bff;
color:white;
padding:8px 15px;
text-decoration:none;
border-radius:5px;
}

</style>

</head>

<body>

<a class="voltar" href="index.php">⬅ Voltar</a>

<h1>DVRs e Switchs</h1>

<table>

<tr>
<th>ID</th>
<th>Tipo</th>
<th>Modelo</th>
<th>IP</th>
<th>Setor</th>
<th>Observação</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['tipo']; ?></td>
<td><?php echo $row['modelo']; ?></td>
<td><?php echo $row['ip']; ?></td>
<td><?php echo $row['setor']; ?></td>
<td><?php echo $row['observacao']; ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>