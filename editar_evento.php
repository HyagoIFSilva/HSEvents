<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

$nome_usuario_logado = $_SESSION['nome'];
$foto_perfil_usuario = $_SESSION['foto'];
$caminho_foto_perfil = 'uploads/' . $foto_perfil_usuario;
$idUsuario = $_SESSION['idUsuario'];

$idEvento = $_GET['id'] ?? 0;
if (!$idEvento) {
    header('Location: galeria.php');
    exit;
}

try {
    $sql = "SELECT * FROM tbcadevento WHERE idCadEvento = ? AND idUsuario = ?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$idEvento, $idUsuario]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$evento) {
        header('Location: galeria.php');
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao buscar o evento: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Evento</title>
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
                    <li><a href="dashboard.php" class="active"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
                    <li><a href="cadastrar_evento.php"><i class="fas fa-plus-square"></i> Cadastrar Evento</a></li>
                    <li><a href="meus_eventos.php"><i class="fas fa-folder-open"></i> Meus Eventos</a></li>
                    <li><a href="galeria.php"><i class="fas fa-images"></i> Galeria Pública</a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
    </aside>

    <main class="main-content">
        <h1>Editar Evento</h1>
        <p>Altere os dados desejados. O envio de uma nova imagem substituirá a antiga.</p>

        <div class="form-wrapper">
            <form action="processa_edicao_evento.php" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="idCadEvento" value="<?php echo $evento['idCadEvento']; ?>">
                <input type="hidden" name="fotoAntiga" value="<?php echo $evento['fotoCadEvento']; ?>">

                <div class="form-group">
                    <label for="nome">Título do Evento</label>
                    <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($evento['nomeCadEvento']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="data">Data</label>
                    <input type="date" name="data" id="data" value="<?php echo $evento['dataCadEvento']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" rows="4" required><?php echo htmlspecialchars($evento['descCadEvento']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="foto_evento">Alterar Imagem do Evento (opcional)</label>
                    <input type="file" name="foto_evento" id="foto_evento" accept="image/*">
                    <div class="preview-container">
                        <p>Imagem atual:</p>
                        <img src="uploads/<?php echo htmlspecialchars($evento['fotoCadEvento']); ?>" alt="Imagem atual do evento" class="preview-image">
                    </div>
                </div>
                <div class="form-actions">
                    <a href="galeria.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>