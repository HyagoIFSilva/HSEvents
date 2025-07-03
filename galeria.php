<?php
session_start();
include 'conexao.php';


if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['idUsuario'];


$sql = "SELECT idCadEvento, nomeCadEvento, dataCadEvento, descCadEvento, fotoCadEvento
        FROM tbcadevento
        WHERE idUsuario = ?
        ORDER BY dataCadEvento DESC";

$stmt = $con->prepare($sql);
$stmt->execute([$usuario_id]);
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Galeria - Meus Eventos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./Styles/galeria.css" />
    <link rel="stylesheet" href="./Styles/modal-delete.css" />
    <link rel="stylesheet" href="./Styles/carrinho.css" />
</head>
<body>

<header class="navbar">
    <div class="navbar-logo">
        <img src="./img/logo.png" alt="Logo" width="60" height="60">
    </div>
    <nav class="navbar-links">
        <a href="./dashboard.php">Dashboard</a>
        <a href="./home.php">Home</a>
        <a href="#" id="cart-icon" class="cart-icon" style="display: none;">
            <i class="fas fa-shopping-cart"></i>
            <span id="cart-count">0</span>
        </a>
        <a href="logout.php">Sair</a>
    </nav>
</header>

<?php if (!empty($eventos)): ?>
<div class="carousel-container">
    <div class="carousel-track">
        <?php foreach ($eventos as $ev): ?>
            <div class="carousel-slide">
                <img src="uploads/<?= htmlspecialchars($ev['fotoCadEvento']) ?>" alt="<?= htmlspecialchars($ev['nomeCadEvento']) ?>">
                <div class="carousel-caption">
                    <h3><?= htmlspecialchars($ev['nomeCadEvento']) ?></h3>
                    <p>Data: <?= date('d/m/Y', strtotime($ev['dataCadEvento'])) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-button prev"><i class="fas fa-chevron-left"></i></button>
    <button class="carousel-button next"><i class="fas fa-chevron-right"></i></button>
    <div class="carousel-nav"></div>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['evento_excluido'])): ?>
    <div class="alert-notification"> <?= $_SESSION['evento_excluido']; ?>
    </div>
    <?php unset($_SESSION['evento_excluido']); ?>
<?php endif; ?>

<main class="gallery-container">
    <h1 class="gallery-title">Meus Eventos</h1>
    <?php if (empty($eventos)): ?>
        <p style="text-align:center;">Nenhum evento cadastrado ainda.</p>
    <?php else: ?>
        <div class="gallery-grid">
            <?php foreach ($eventos as $ev): 
                $precoIngresso = 49.90;
            ?>
                <div class="gallery-card">
                    <div class="card-image-container">
                        <img src="uploads/<?= htmlspecialchars($ev['fotoCadEvento']) ?>" alt="<?= htmlspecialchars($ev['nomeCadEvento']) ?>" class="card-image">
                        <div class="card-overlay">
                            <a href="editar_evento.php?id=<?= $ev['idCadEvento'] ?>" class="btn-manage btn-edit">
                                <i class="fas fa-pencil-alt"></i> Editar
                            </a>
                            <button type="button" class="btn-manage btn-delete" onclick="abrirModalExclusao(<?= $ev['idCadEvento'] ?>)">
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title"><?= htmlspecialchars($ev['nomeCadEvento']) ?></h3>
                        <p class="card-date"><i class="fas fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($ev['dataCadEvento'])) ?></p>
                        <p class="card-description"><?= htmlspecialchars($ev['descCadEvento']) ?></p>
                        <div class="card-footer">
                            <span class="ticket-price">R$ <?= number_format($precoIngresso, 2, ',', '.') ?></span>
                            <button class="comprar-btn"
                                data-id="evt-<?= $ev['idCadEvento'] ?>"
                                data-nome="Ingresso: <?= htmlspecialchars(addslashes($ev['nomeCadEvento'])) ?>"
                                data-preco="<?= $precoIngresso ?>"
                                data-img="uploads/<?= htmlspecialchars($ev['fotoCadEvento']) ?>">
                                Comprar Ingresso <i class="fas fa-ticket-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<div id="deleteConfirmModal" class="modal">
    <div class="modal-content-delete">
        <div class="modal-header-delete">
            <span class="close-delete" onclick="fecharModalExclusao()">&times;</span>
            <h2>Confirmar Exclusão</h2>
        </div>
        <div class="modal-body-delete">
            <p>Você tem certeza de que deseja excluir este evento? Esta ação não pode ser desfeita.</p>
        </div>
        <div class="modal-footer-delete">
            <form id="deleteForm" action="excluir_evento.php" method="POST" style="display:inline;">
                <input type="hidden" name="idCadEvento" id="deleteIdCadEvento" value="">
                <button type="button" class="btn-cancel" onclick="fecharModalExclusao()">Cancelar</button>
                <button type="submit" class="btn-confirm-delete">Sim, Excluir</button>
            </form>
        </div>
    </div>
</div>

<div id="sidebar-cart" class="sidebar-cart">
    <div class="cart-header">
      <h3>Resumo do carrinho</h3>
      <button id="close-cart" class="close-cart">&times;</button>
    </div>
    <div id="cart-items" class="cart-items"></div>
    <div class="cart-footer">
      <div class="subtotal">
        <span>Subtotal</span>
        <span id="subtotal-price">R$ 0,00</span>
      </div>
      <button class="finalizar-pedido">FECHAR PEDIDO</button>
      <a href="#" id="continuar-comprando">Continuar comprando</a>
    </div>
</div>
<div id="overlay" class="overlay"></div>

<script src="./js/galeria.js"></script>
<script src="./js/carrinho.js"></script>

</body>
</html>