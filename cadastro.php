<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_FILES['fotoCadEvento']) &&
    $_FILES['fotoCadEvento']['error'] === 0
) {

    $titulo      = $_POST['nomeCadEvento'];
    $data_evento = $_POST['dataCadEvento'];
    $descricao   = $_POST['descCadEvento'];

    $imagem    = $_FILES['fotoCadEvento'];
    $nome_img  = $imagem['name'];
    $temp_img  = $imagem['tmp_name'];

    $extensao   = strtolower(pathinfo($nome_img, PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];

    if (!in_array($extensao, $permitidas)) {
        $_SESSION['msg_erro'] = "Erro: Formato de imagem inválido.";
        header('Location: cadastrar_evento.php');
        exit();
    }

    $pasta    = 'uploads/';
    $contador = 1;
    foreach (glob($pasta . "evento*.*") as $arquivo) {
        if (preg_match('/evento(\d+)\./', basename($arquivo), $m)) {
            $contador = max($contador, (int)$m[1] + 1);
        }
    }
    $nome_final    = "evento{$contador}.{$extensao}";
    $caminho_final = $pasta . $nome_final;

    if (move_uploaded_file($temp_img, $caminho_final)) {
        try {
            $sql = "INSERT INTO tbcadevento
                    (nomeCadEvento, dataCadEvento, descCadEvento, fotoCadEvento, idUsuario)
                    VALUES (?,?,?,?,?)";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                $titulo,
                $data_evento,
                $descricao,
                $nome_final,
                $_SESSION['idUsuario']
            ]);

            $_SESSION['evento_sucesso'] = true;
            header('Location: cadastrar_evento.php');
            exit();

        } catch (PDOException $e) {
            $_SESSION['msg_erro'] = "Erro ao cadastrar evento: " . $e->getMessage();
            header('Location: cadastrar_evento.php');
            exit();
        }
    } else {
        $_SESSION['msg_erro'] = "Erro ao fazer upload da imagem.";
        header('Location: cadastrar_evento.php');
        exit();
    }
} else {
    $_SESSION['msg_erro'] = "Envie todos os campos e uma imagem válida.";
    header('Location: cadastrar_evento.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Cadastro</title>
    <link rel="stylesheet" href="./Styles/login.css">

    <?php if ($redirect): ?>
        <script>
           
            setTimeout(() => { window.location.href = "<?php echo $redirect; ?>"; }, 3000);
        </script>
    <?php endif; ?>
</head>

<body>
<header class="navbar">
    <div class="navbar-logo">
        <img src="./img/logo.png" alt="Logo" width="60" height="60">
    </div>
    <nav class="navbar-links">
        <a href="./cadastro.php">Registrar</a>
        <a href="./login.php">Login</a>
        <a href="./galeria.php">Galeria</a>
        <a href="./home.php">Home</a>
    </nav>
</header>

<section>
    <div class="form-box">

        <?php if ($mensagem): ?>
            <div class="<?php echo $classe; ?>"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <?php if (!$redirect): ?>
            <form method="POST" action="">
                <h2>Registrar</h2>
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" name="nome" required>
                    <label>Digite seu Nome:</label>
                </div>

                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" name="login" required>
                    <label>Digite seu e-mail:</label>
                </div>

                <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="senha" required>
                    <label>Digite sua senha:</label>
                </div>

                <button type="submit">Enviar</button>

                <div class="register">
                    <p>Já tem uma conta? <a href="login.php">Login</a></p>
                </div>
            </form>
        <?php endif; ?>

    </div>
</section>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>

