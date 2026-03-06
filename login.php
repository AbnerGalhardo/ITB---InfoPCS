<?php
session_start();
require_once "config/db.php";

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $senha   = $_POST["senha"];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user["senha"])) {
        $_SESSION["usuario"] = $user["usuario"];
        $_SESSION["nome"] = $user["nome"];
        $_SESSION["perfil"] = $user["perfil"];
        header("Location: dashboard/index.php");
        exit;
    } else {
        $erro = "Usuário ou senha inválidos";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<link rel="shortcut icon" href="logo.png" type="image/x-icon">
<head>
    <meta charset="UTF-8">
    <title>Login - InfoPCS</title>
    <style>
        body {
            margin: 0;
            background: linear-gradient(135deg, #121212, #1e1e1e);
            font-family: Arial, Helvetica, sans-serif;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-box {
            background: #2a2a2a;
            padding: 35px 30px;
            border-radius: 10px;
            width: 320px;
            box-shadow: 0 0 25px rgba(0,0,0,0.6);
            text-align: center;
        }

        .login-box img {
            width: 90px;
            margin-bottom: 15px;
        }

        .login-box h2 {
            margin: 0 0 20px 0;
            color: #4fc3f7;
        }

        input {
            width: 100%;
            padding: 11px;
            margin-bottom: 12px;
            border: none;
            border-radius: 6px;
            background: #1e1e1e;
            color: #fff;
        }

        input::placeholder {
            color: #aaa;
        }

        button {
            width: 100%;
            padding: 11px;
            background: #4fc3f7;
            color: #000;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #35b5ee;
        }

        .erro {
            background: #ff6b6b20;
            border: 1px solid #ff6b6b;
            color: #ff6b6b;
            padding: 8px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <img src="img/logo.png" alt="ITB">

    <h2>InfoPCS</h2>

    <?php if ($erro): ?>
        <div class="erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="usuario" placeholder="Usuário" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
</div>

</body>
</html>
