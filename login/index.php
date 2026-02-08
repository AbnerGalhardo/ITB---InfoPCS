<?php
session_start();
require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha   = hash("sha256", $_POST["senha"]);

    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? AND senha = ?");
    $sql->execute([$usuario, $senha]);

    if ($sql->rowCount() == 1) {
        $_SESSION["usuario"] = $usuario;
        header("Location: ../dashboard/");
        exit;
    } else {
        $erro = "Usuário ou senha inválidos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - InfoPCS</title>
</head>
<body>
    <h2>Login InfoPCS</h2>

    <?php if(isset($erro)) echo "<p style='color:red'>$erro</p>"; ?>

    <form method="POST">
        <input type="text" name="usuario" placeholder="Usuário" required><br><br>
        <input type="password" name="senha" placeholder="Senha" required><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
