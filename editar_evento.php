<?php
session_start();
include 'conexao.php';


if (!isset($_SESSION['idUsuario']) || !isset($_SESSION['nome']) || !isset($_SESSION['foto'])) {
    header('Location: login.php');
    exit();
}

$nome = $_SESSION['nome'];
$foto_perfil = $_SESSION['foto'];
$caminho_foto_perfil = 'uploads/' . $foto_perfil;
$idUsuario = $_SESSION['idUsuario'];

$idEvento = $_GET['id'] ?? 0;
if (!$idEvento) {
    echo "ID do evento não fornecido.";
    exit;
}


try {
    $sql = "SELECT * FROM tbcadevento WHERE idCadEvento = ? AND idUsuario = ?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$idEvento, $idUsuario]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$evento) {
        echo "Evento não encontrado ou você não tem permissão para editá-lo.";
        exit;
    }
} catch (PDOException $e) {
    echo "Erro ao buscar o evento: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="./Styles/dashboard.css">
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
                <li><a href="dashboard.php">🏠 Dashboard</a></li>
                <li><a href="cadastrar_evento.php">📒 Cadastrar Evento</a></li>
                <li><a href="meus_eventos.php" class="active">📁 Meus Eventos</a></li>
                <li><a href="galeria.php">🖼️ Galeria Geral</a></li>
            </ul>
        </nav>
        <div class="logout">
            <a href="login.php">🚪 Logout</a>
        </div>
    </aside>

    <main class="main-content">
        <h1>Editar Evento</h1>
        <p>Altere os dados abaixo e clique em salvar.</p>

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
                    <label for="foto">Imagem de Capa (opcional: envie apenas se quiser alterar)</label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                    <div class="preview-container" style="margin-top:15px;">
                        <p>Imagem atual:</p>
                        <img src="uploads/<?php echo htmlspecialchars($evento['fotoCadEvento']); ?>" alt="Imagem atual" style="max-width:200px; border-radius:8px;">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Salvar Alterações</button>
                    <a href="meus_eventos.php" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>