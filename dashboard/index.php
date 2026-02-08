<?php
require_once "../config/auth.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - InfoPCS</title>
</head>
<body>
    <h1>Bem-vindo ao InfoPCS</h1>
    <p>Usuário logado: <?php echo $_SESSION["usuario"]; ?></p>

    <a href="../dashboard/maquinas.php">Ver máquinas</a>
</body>
</html>
