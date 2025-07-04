<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}
$nome = $_SESSION['nome'];
$foto_perfil = $_SESSION['foto'];
$caminho_foto_perfil = 'uploads/' . $foto_perfil;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Novo Evento</title>
    <link rel="stylesheet" href="./Styles/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="profile">
            <img src="<?php echo htmlspecialchars($caminho_foto_perfil); ?>" alt="Foto de Perfil" class="profile-pic">
            <h3><?php echo htmlspecialchars($nome); ?></h3>
        </div>
        <h2>Menu</h2>
        <nav>
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
                <li><a href="cadastrar_evento.php" class="active"><i class="fas fa-plus-square"></i> Cadastrar Evento</a></li>
                <li><a href="meus_eventos.php"><i class="fas fa-folder-open"></i> Meus Eventos</a></li>
                <li><a href="galeria.php"><i class="fas fa-images"></i> Galeria Pública</a></li>
            </ul>
        </nav>
        <div class="logout">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
        </div>
    </aside>

    <main class="main-content">
        <h1>Criar Novo Evento</h1>
        <p>Preencha os campos para adicionar um novo evento à sua lista.</p>

        <div class="form-wrapper">
            <form action="processa_cadastro_evento.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nome">Título do Evento</label>
                    <input type="text" name="nome" id="nome" required placeholder="Ex: Final do Campeonato Mundial">
                </div>
                <div class="form-group">
                    <label for="data">Data do Evento</label>
                    <input type="date" name="data" id="data" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" rows="5" required placeholder="Descreva os detalhes do seu evento..."></textarea>
                </div>
                <div class="form-group">
                    <label>Imagem de Capa do Evento</label>
                    <label for="file-upload-input" class="file-upload-wrapper">
                        <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <p>Clique para enviar ou arraste e solte</p>
                        <span id="file-name">Nenhum arquivo selecionado</span>
                    </label>
                    <input type="file" name="foto_evento" id="file-upload-input" accept="image/*" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Cadastrar Evento</button>
                </div>
            </form>
        </div>
    </main>
</div>
<script>
    const fileInput = document.getElementById('file-upload-input');
    const fileNameSpan = document.getElementById('file-name');
    if(fileInput && fileNameSpan){
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                fileNameSpan.textContent = fileInput.files[0].name;
            } else {
                fileNameSpan.textContent = 'Nenhum arquivo selecionado';
            }
        });
    }
</script>
</body>
</html>