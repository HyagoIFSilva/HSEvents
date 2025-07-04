<?php
session_start();
include 'conexao.php';

$erro     = '';
$mensagem = '';
$classe   = '';
$redirect = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['login'] ?? '');
    $senha   = trim($_POST['senha'] ?? '');

    $sql  = 'SELECT idUsuario, nomeUsuario, senhaUsuario, foto FROM tbusuario WHERE emailUsuario = ?';
    $stmt = $con->prepare($sql);
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senhaUsuario'])) {
        
        $_SESSION['idUsuario'] = $user['idUsuario'];
        $_SESSION['usuario']   = $usuario; 
        $_SESSION['nome']      = $user['nomeUsuario'];
        $_SESSION['foto']      = $user['foto']; 

        $mensagem = 'Login efetuado com sucesso! Redirecionando...';
    
        $classe   = 'login-message success';
        $redirect = 'dashboard.php';

    } else {
       
        $erro   = 'Usuário ou senha incorretos.';
   
        $classe = 'login-message error';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Login</title>
    <link rel="stylesheet" href="./Styles/login.css">

    <?php if ($redirect): ?>
        <script>
            setTimeout(() => { window.location.href = "<?php echo $redirect; ?>"; }, 2000);
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
        <a href="./galeria.php">Galeria</a>
        <a href="./home.php">Home</a>
    </nav>
</header>

<section>
    <div class="form-box">
        <div class="form-content"> <?php if ($mensagem || $erro): ?>
                <div class="<?php echo $classe; ?>">
                    <?php echo $mensagem ?: $erro; ?>
                </div>
            <?php endif; ?>

            <?php if (!$redirect):?>
                <form method="POST" action="login.php">
                    <h2>Login</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" name="login" required>
                        <label>Digite seu e-mail:</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="senha" required>
                        <label>Senha:</label>
                    </div>
                    <div class="forget">
                        <label><a href="#">Esqueceu a senha?</a></label>
                    </div>
                    <button type="submit">Log in</button>
                    <div class="register">
                        <p>Não tem uma conta? <a href="./registrar_usuario.php">Registre-se</a></p>
                    </div>
                </form>
            <?php endif; ?>

        </div>
    </div>
</section>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>