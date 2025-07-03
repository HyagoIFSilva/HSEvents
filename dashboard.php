<?php
session_start();

// Verifica se o usuário está logado, buscando pelas sessões essenciais.
// Adicionei a verificação da 'foto' e 'idUsuario' que serão necessárias.
if (!isset($_SESSION['idUsuario']) || !isset($_SESSION['nome']) || !isset($_SESSION['foto'])) {
    header('Location: login.php');
    exit();
}

$nome = $_SESSION['nome'];
$foto_perfil = $_SESSION['foto']; // Pega o nome do arquivo da foto da sessão.
$caminho_foto_perfil = 'uploads/' . $foto_perfil; // Constrói o caminho completo da imagem.
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./Styles/dashboard.css">
</head>
<body>
    <div class="dashboard">
    
        <aside class="sidebar">
            <div class="profile">
                <img src="<?php echo $caminho_foto_perfil; ?>" alt="Foto de Perfil" class="profile-pic">
                <h3><?php echo $nome; ?></h3>
            </div>
            
            <h2>Menu</h2>
            <nav>
                <ul>
                    <li><a href="cadastrar_evento.php">📒 Cadastrar Evento</a></li>
                    <li><a href="meus_eventos.php">📁 Meus Eventos</a></li>
                    <li><a href="galeria.php">🖼️ Galeria Geral</a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="login.php">🚪 Logout</a>
            </div>
            
        </aside>

        <main class="main-content">
            <h1>Bem-vindo(a), <?php echo $nome; ?>!</h1>
            <p>Este é o seu painel de controle. Aqui você pode gerenciar seus eventos, visualizar detalhes e muito mais.</p>
            <div class="info-boxes">
                <div class="info-box">
                    <h3>Gerencie seus eventos</h3>
                    <p>Cadastre, edite e visualize todos os eventos que você organizou.</p>
                </div>
                <div class="info-box">
                    <h3>Organização facilitada</h3>
                    <p>Tenha controle total sobre as datas, locais e descrições dos seus eventos.</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>