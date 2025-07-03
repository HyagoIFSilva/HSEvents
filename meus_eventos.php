<?php
session_start();
include 'conexao.php'; 

if (!isset($_SESSION['idUsuario']) || !isset($_SESSION['nome']) || !isset($_SESSION['foto'])) {
    header('Location: login.php');
    exit();
}

$idUsuario = $_SESSION['idUsuario'];
$nome = $_SESSION['nome'];
$foto_perfil = $_SESSION['foto'];
$caminho_foto_perfil = 'uploads/' . $foto_perfil;

try {
    $sql = "SELECT idCadEvento, nomeCadEvento, dataCadEvento, descCadEvento, fotoCadEvento 
            FROM tbcadevento 
            WHERE idUsuario = ? 
            ORDER BY dataCadEvento DESC";
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
            <h1>Meus Eventos</h1>
            <p>Gerencie, edite e visualize os eventos que você criou.</p>

            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'editado'): ?>
                <div class="mensagem-sucesso">Evento atualizado com sucesso!</div>
            <?php endif; ?>
            
            <div class="event-grid">
                <?php if (!empty($eventos)): ?>
                    <?php foreach ($eventos as $index => $evento): ?>
                        <div class="event-card" style="--animation-delay: <?php echo $index * 100; ?>ms;">
                            <div class="card-image-container">
                                <img src="uploads/<?php echo htmlspecialchars($evento['fotoCadEvento']); ?>" alt="Imagem do Evento">
                                <div class="card-date-overlay">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17 3H7C4.79086 3 3 4.79086 3 7V17C3 19.2091 4.79086 21 7 21H17C19.2091 21 21 19.2091 21 17V7C21 4.79086 19.2091 3 17 3ZM19 17C19 18.1046 18.1046 19 17 19H7C5.89543 19 5 18.1046 5 17V7C5 5.89543 5.89543 5 7 5H17C18.1046 5 19 5.89543 19 7V17Z"></path><path d="M15 11H13V13H15V11ZM15 7H13V9H15V7ZM11 11H9V13H11V11ZM11 7H9V9H11V7ZM7 11H5V13H7V11Z"></path>
                                    </svg>
                                    <span><?php echo date('d/m/Y', strtotime($evento['dataCadEvento'])); ?></span>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3><?php echo htmlspecialchars($evento['nomeCadEvento']); ?></h3>
                                <p class="card-description"><?php echo htmlspecialchars($evento['descCadEvento']); ?></p>
                            </div>
                            <div class="card-action-bar">
                                <button class="btn-edit open-modal-btn" 
                                        data-id="<?php echo $evento['idCadEvento']; ?>"
                                        data-nome="<?php echo htmlspecialchars($evento['nomeCadEvento']); ?>"
                                        data-data="<?php echo $evento['dataCadEvento']; ?>"
                                        data-descricao="<?php echo htmlspecialchars($evento['descCadEvento']); ?>"
                                        data-foto="<?php echo htmlspecialchars($evento['fotoCadEvento']); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M16.707 2.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-13 13a1 1 0 0 1-.707.293H1a1 1 0 0 1-1-1v-7a1 1 0 0 1 .293-.707l13-13zM15.293 4.414l-10 10V18h3.586l10-10L15.293 4.414zM17.414 6l-2-2L17 2.414 19.586 5 17.414 6z"></path></svg>
                                    <span>Editar Evento</span>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Você ainda não cadastrou nenhum evento.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <div id="editModal" class="modal-overlay" style="display: none;">
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
                        <label for="edit-foto">Nova Imagem (opcional)</label>
                        <input type="file" name="foto" id="edit-foto" accept="image/*">
                        <div class="preview-container" style="margin-top: 15px;">
                            <p id="edit-preview-label">Imagem atual:</p>
                            <img id="edit-preview-img" src="" alt="Imagem atual" style="max-width:200px; border-radius:8px; display: block;">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn">Salvar Alterações</button>
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
            const closeModalButton = modal.querySelector('.close-modal-btn');
            
            const editIdInput = modal.querySelector('#edit-id');
            const editFotoAntigaInput = modal.querySelector('#edit-foto-antiga');
            const editNomeInput = modal.querySelector('#edit-nome');
            const editDataInput = modal.querySelector('#edit-data');
            const editDescricaoInput = modal.querySelector('#edit-descricao');
            const editFotoInput = modal.querySelector('#edit-foto');
            const editPreviewLabel = modal.querySelector('#edit-preview-label');
            const editPreviewImg = modal.querySelector('#edit-preview-img');

            openModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const eventData = this.dataset;
                    
                    editIdInput.value = eventData.id;
                    editFotoAntigaInput.value = eventData.foto;
                    editNomeInput.value = eventData.nome;
                    editDataInput.value = eventData.data;
                    editDescricaoInput.value = eventData.descricao;
                    
                    editPreviewImg.src = 'uploads/' + eventData.foto;
                    editPreviewLabel.textContent = 'Imagem atual:';
                    editFotoInput.value = '';

                    modal.style.display = 'flex';
                });
            });

            editFotoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        editPreviewImg.src = e.target.result;
                        editPreviewLabel.textContent = 'Nova imagem (pré-visualização):';
                    }
                    reader.readAsDataURL(file);
                }
            });

            function closeModal() {
                modal.style.display = 'none';
            }

            closeModalButton.addEventListener('click', closeModal);

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>