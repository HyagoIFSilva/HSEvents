<?php
session_start();
include 'conexao.php';

// Verifica se o usuário está logado, se não estiver, redireciona para o login.
if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

// O id do usuário logado ainda é útil para outras funcionalidades, então o mantemos.
$usuario_id = $_SESSION['idUsuario'];

// MUDANÇA 1: A query foi alterada para buscar TODOS os eventos disponíveis no sistema,
// e não apenas os que o usuário logado criou. A cláusula "WHERE idUsuario = ?" foi removida.
$sql = "SELECT idCadEvento, nomeCadEvento, dataCadEvento, descCadEvento, fotoCadEvento
        FROM tbcadevento
        ORDER BY dataCadEvento DESC";

$stmt = $con->prepare($sql);
// MUDANÇA 2: Como a cláusula WHERE foi removida, não precisamos mais passar o ID do usuário na execução.
$stmt->execute();
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Galeria de Eventos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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

<div class="swiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="img/carousel-1.png" alt="Arena de E-sports">
            <div class="carousel-caption">
                <h3>Campeonatos Épicos</h3>
                <p>Viva a emoção das grandes finais.</p>
            </div>
        </div>
        <div class="swiper-slide">
            <img src="img/carousel-2.png" alt="Equipe de E-sports vitoriosa">
            <div class="carousel-caption">
                <h3>Vitória em Equipe</h3>
                <p>Celebre as conquistas dos seus times favoritos.</p>
            </div>
        </div>
        <div class="swiper-slide">
            <img src="img/carousel-3.png" alt="Gamer focada em competição">
            <div class="carousel-caption">
                <h3>Foco Total</h3>
                <p>A concentração máxima dos pro-players.</p>
            </div>
        </div>
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-pagination"></div>
</div>

<?php if (isset($_SESSION['evento_excluido']) || isset($_SESSION['evento_editado'])): ?>
    <div class="alert-notification">
        <?= $_SESSION['evento_excluido'] ?? $_SESSION['evento_editado']; ?>
    </div>
    <?php 
        unset($_SESSION['evento_excluido']); 
        unset($_SESSION['evento_editado']);
    ?>
<?php endif; ?>

<main class="gallery-container">
    <h1 class="gallery-title">Eventos Disponíveis</h1>
    <?php if (empty($eventos)): ?>
        <p style="text-align:center;">Nenhum evento disponível no momento.</p>
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

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="./js/galeria.js"></script>
<script src="./js/carrinho.js"></script>

</body>
</html>