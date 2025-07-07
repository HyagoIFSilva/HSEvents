<?php
    require_once 'config.php';
    include 'conexao.php';
    
    $page_title = "Galeria de Eventos"; 
    include 'header.php';

    if (!isset($_SESSION['idUsuario'])) {
        header('Location: ' . BASE_URL . 'login.php');
        exit();
    }
    $usuario_id = $_SESSION['idUsuario'];

    $busca = $_GET['busca'] ?? '';
    $sql = "SELECT idCadEvento, nomeCadEvento, dataCadEvento, descCadEvento, fotoCadEvento, precoCadEvento, idUsuario FROM tbcadevento";
    $params = [];
    if ($busca) {
        $sql .= " WHERE nomeCadEvento LIKE ?";
        $params[] = '%' . $busca . '%';
    }
    $sql .= " ORDER BY dataCadEvento DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute($params);
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>Styles/galeria.css" /> 
<link rel="stylesheet" href="<?php echo BASE_URL; ?>Styles/modal-delete.css" />

<div class="swiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="<?php echo BASE_URL; ?>img/carousel-1.png" alt="Arena de E-sports"><div class="carousel-caption"><h3>Campeonatos Épicos</h3><p>Viva a emoção das grandes finais.</p></div></div>
        <div class="swiper-slide"><img src="<?php echo BASE_URL; ?>img/carousel-2.png" alt="Equipe de E-sports vitoriosa"><div class="carousel-caption"><h3>Vitória em Equipe</h3><p>Celebre as conquistas dos seus times favoritos.</p></div></div>
        <div class="swiper-slide"><img src="<?php echo BASE_URL; ?>img/carousel-3.png" alt="Gamer focada em competição"><div class="carousel-caption"><h3>Foco Total</h3><p>A concentração máxima dos pro-players.</p></div></div>
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-pagination"></div>
</div>

<div class="gallery-header">
    <h1 class="gallery-title">Eventos Disponíveis</h1>
    <div class="search-container">
        <form action="<?php echo BASE_URL; ?>galeria.php" method="GET">
            <input type="text" name="busca" placeholder="Buscar evento por nome..." value="<?php echo htmlspecialchars($busca); ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</div>

<div class="gallery-container">
    <?php if (isset($_SESSION['evento_excluido'])): ?>
        <div class="alert-notification"><?php echo $_SESSION['evento_excluido']; unset($_SESSION['evento_excluido']); ?></div>
    <?php endif; ?>

    <?php if (empty($eventos)): ?>
        <p style="text-align:center; margin-top: 40px; font-size: 1.2rem;">Nenhum evento encontrado.</p>
    <?php else: ?>
        <div class="gallery-grid">
            <?php foreach ($eventos as $ev): ?>
                <div class="gallery-card">
                    <?php if (isset($usuario_id) && $ev['idUsuario'] == $usuario_id): ?>
                    <div class="card-admin-actions">
                        <button class="options-btn"><i class="fas fa-ellipsis-v"></i></button>
                        <div class="options-dropdown">
                            <a href="editar_evento.php?id=<?php echo $ev['idCadEvento']; ?>"><i class="fas fa-pencil-alt"></i> Editar</a>
                            <a href="#" class="delete-link" data-id="<?php echo $ev['idCadEvento']; ?>"><i class="fas fa-trash-alt"></i> Excluir</a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <a href="detalhes_evento.php?id=<?php echo $ev['idCadEvento']; ?>" class="card-link">
                        <div class="card-image-container"><img src="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($ev['fotoCadEvento']); ?>" alt="<?php echo htmlspecialchars($ev['nomeCadEvento']); ?>" class="card-image" loading="lazy"></div>
                        <div class="card-content">
                            <h3 class="card-title"><?php echo htmlspecialchars($ev['nomeCadEvento']); ?></h3>
                            <p class="card-date"><i class="fas fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($ev['dataCadEvento'])); ?></p>
                            <p class="card-description"><?php echo htmlspecialchars($ev['descCadEvento']); ?></p>
                        </div>
                    </a>
                    <div class="card-footer">
                        <span class="ticket-price">R$ <?php echo number_format($ev['precoCadEvento'], 2, ',', '.'); ?></span>
                        <button class="comprar-btn" data-id="evt-<?php echo $ev['idCadEvento']; ?>" data-nome="Ingresso: <?php echo htmlspecialchars($ev['nomeCadEvento']); ?>" data-preco="<?php echo $ev['precoCadEvento']; ?>" data-img="<?php echo BASE_URL; ?>uploads/<?php echo htmlspecialchars($ev['fotoCadEvento']); ?>">
                            Comprar <i class="fas fa-ticket-alt"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div id="deleteConfirmModal" class="modal">
    <div class="modal-content-delete">
        <div class="modal-header-delete"><span class="close-delete">&times;</span><h2>Confirmar Exclusão</h2></div>
        <div class="modal-body-delete"><p>Você tem certeza de que deseja excluir este evento? Esta ação não pode ser desfeita.</p></div>
        <div class="modal-footer-delete">
            <form id="deleteForm" action="<?php echo BASE_URL; ?>excluir_evento.php" method="POST">
                <input type="hidden" name="idCadEvento" id="deleteIdCadEvento" value="">
                <button type="button" class="btn-cancel">Cancelar</button>
                <button type="submit" class="btn-confirm-delete">Sim, Excluir</button>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo BASE_URL; ?>js/galeria.js"></script>

<?php 
    include 'footer.php'; 
?>