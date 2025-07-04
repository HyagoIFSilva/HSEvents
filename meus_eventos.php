<?php
session_start();
include 'conexao.php'; 

if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

$idUsuario = $_SESSION['idUsuario'];
$nome = $_SESSION['nome'];
$foto_perfil = $_SESSION['foto'];
$caminho_foto_perfil = 'uploads/' . $foto_perfil;

try {
    $sql = "SELECT * FROM tbcadevento WHERE idUsuario = ? ORDER BY dataCadEvento DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute([$idUsuario]);
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $erro = "Erro ao buscar eventos: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Eventos</title>
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
                    <li><a href="cadastrar_evento.php"><i class="fas fa-plus-square"></i> Cadastrar Evento</a></li>
                    <li><a href="meus_eventos.php" class="active"><i class="fas fa-folder-open"></i> Meus Eventos</a></li>
                    <li><a href="galeria.php"><i class="fas fa-images"></i> Galeria Pública</a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </aside>

        <main class="main-content">
            <h1>Meus Eventos</h1>
            <p>Gerencie, edite e visualize os eventos que você criou.</p>

            <?php if (isset($_SESSION['evento_editado'])): ?>
                <div class="alert-notification"><?= $_SESSION['evento_editado']; ?></div>
                <?php unset($_SESSION['evento_editado']); ?>
            <?php endif; ?>
            
            <div class="event-grid">
                <?php if (!empty($eventos)): ?>
                    <?php foreach ($eventos as $index => $evento): ?>
                        <div class="event-card">
                            <div class="card-image-container">
                                <img src="uploads/<?= htmlspecialchars($evento['fotoCadEvento']); ?>" alt="Imagem do Evento">
                            </div>
                            <div class="card-content">
                                <h3><?= htmlspecialchars($evento['nomeCadEvento']); ?></h3>
                                <div class="card-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span><?= date('d/m/Y', strtotime($evento['dataCadEvento'])); ?></span>
                                </div>
                                <p class="card-description"><?= htmlspecialchars($evento['descCadEvento']); ?></p>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary card-footer-action open-modal-btn" 
                                    data-id="<?= $evento['idCadEvento']; ?>"
                                    data-nome="<?= htmlspecialchars($evento['nomeCadEvento']); ?>"
                                    data-data="<?= $evento['dataCadEvento']; ?>"
                                    data-descricao="<?= htmlspecialchars($evento['descCadEvento']); ?>"
                                    data-foto="<?= htmlspecialchars($evento['fotoCadEvento']); ?>">
                                    <i class="fas fa-edit"></i> Editar Evento
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Você ainda não cadastrou nenhum evento. <a href="cadastrar_evento.php">Crie o primeiro!</a></p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <div id="editModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Evento</h2>
                <button class="close-modal-btn">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="processa_edicao_evento.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idCadEvento" id="edit-id">
                    <input type="hidden" name="fotoAntiga" id="edit-foto-antiga">
                    <div class="form-group">
                        <label for="edit-nome">Título do Evento</label>
                        <input type="text" name="nome" id="edit-nome" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-data">Data</label>
                        <input type="date" name="data" id="edit-data" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-descricao">Descrição</label>
                        <textarea name="descricao" id="edit-descricao" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nova Imagem (opcional)</label>
                        <input type="file" name="foto_evento" id="edit-foto" accept="image/*">
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary close-modal-btn">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('editModal');
    if (!modal) return;

    const openModalButtons = document.querySelectorAll('.open-modal-btn');
    const closeModalButtons = modal.querySelectorAll('.close-modal-btn');
    
    const editIdInput = modal.querySelector('#edit-id');
    const editFotoAntigaInput = modal.querySelector('#edit-foto-antiga');
    const editNomeInput = modal.querySelector('#edit-nome');
    const editDataInput = modal.querySelector('#edit-data');
    const editDescricaoInput = modal.querySelector('#edit-descricao');
    const editFotoInput = modal.querySelector('#edit-foto');

    openModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            const eventData = this.dataset;
            
            editIdInput.value = eventData.id;
            editFotoAntigaInput.value = eventData.foto;
            editNomeInput.value = eventData.nome;
            editDataInput.value = eventData.data;
            editDescricaoInput.value = eventData.descricao;
            editFotoInput.value = '';
            modal.style.display = 'flex';
        });
    });

    function closeModal() {
        modal.style.display = 'none';
    }

    closeModalButtons.forEach(btn => btn.addEventListener('click', closeModal));

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });
});
</script>
</body>
</html>