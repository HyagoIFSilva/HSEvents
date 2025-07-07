<?php
if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

$nome_usuario_logado = $_SESSION['nome'] ?? 'Usuário';
$foto_perfil_usuario = $_SESSION['foto'] ?? 'default.png';
$caminho_foto_perfil = 'uploads/' . $foto_perfil_usuario;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title ?? 'Dashboard'; ?></title>
    <link rel="stylesheet" href="./Styles/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="profile">
            <img src="<?php echo htmlspecialchars($caminho_foto_perfil); ?>" alt="Foto de Perfil" class="profile-pic">
            <h3><?php echo htmlspecialchars($nome_usuario_logado); ?></h3>
        </div>
        <h2>Menu</h2>
        <nav>
            <ul>
                <li><a href="dashboard.php">🏠 Dashboard</a></li>
                <li><a href="cadastrar_evento.php">📒 Cadastrar Evento</a></li>
                <li><a href="galeria.php">📁 Galeria de Eventos</a></li>
                <li><a href="meus_pedidos.php">🛒 Meus Pedidos</a></li>
            </ul>
        </nav>
        <div class="logout">
            <a href="logout.php">🚪 Sair</a>
        </div>
    </aside>
    <main class="main-content">