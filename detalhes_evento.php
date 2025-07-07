<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

$idEvento = $_GET['id'] ?? 0;
if (!$idEvento) {
    header('Location: galeria.php');
    exit;
}

try {
    $sql = "SELECT * FROM tbcadevento WHERE idCadEvento = ?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$idEvento]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$evento) {
      
        $_SESSION['evento_nao_encontrado'] = "O evento que você tentou acessar não existe.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo htmlspecialchars($evento['nomeCadEvento']); ?> - Detalhes</title>
    <link rel="stylesheet" href="./Styles/galeria.css" />
    <link rel="stylesheet" href="./Styles/carrinho.css" />
    <link rel="stylesheet" href="./Styles/detalhes_evento.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header class="navbar">
    <div class="navbar-logo">
        <img src="./img/logo.png" alt="Logo" width="60" height="60">
    </div>
    <nav class="navbar-links">
        <a href="./dashboard.php">Dashboard</a>
        <a href="./galeria.php">Galeria</a>
        <a href="#" id="cart-icon" class="cart-icon" style="display: none;">
            <i class="fas fa-shopping-cart"></i>
            <span id="cart-count">0</span>
        </a>
        <a href="logout.php">Sair</a>
    </nav>
</header>

<main class="detalhes-container">
    <div class="detalhes-imagem">
        <img src="uploads/<?php echo htmlspecialchars($evento['fotoCadEvento']); ?>" alt="<?php echo htmlspecialchars($evento['nomeCadEvento']); ?>">
    </div>
    <div class="detalhes-info">
        <h1><?php echo htmlspecialchars($evento['nomeCadEvento']); ?></h1>
        <p class="data-evento"><i class="fas fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($evento['dataCadEvento'])); ?></p>
        <p class="descricao-evento"><?php echo nl2br(htmlspecialchars($evento['descCadEvento'])); ?></p>
        <div class="compra-box">
            <span class="ticket-price">R$ <?php echo number_format($evento['precoCadEvento'], 2, ',', '.'); ?></span>
             <button class="comprar-btn"
                data-id="evt-<?php echo $evento['idCadEvento']; ?>"
                data-nome="Ingresso: <?php echo htmlspecialchars($evento['nomeCadEvento']); ?>"
                data-preco="<?php echo $evento['precoCadEvento']; ?>"
                data-img="uploads/<?php echo htmlspecialchars($evento['fotoCadEvento']); ?>">
                Comprar Ingresso <i class="fas fa-ticket-alt"></i>
            </button>
        </div>
    </div>
</main>

<div id="sidebar-cart" class="sidebar-cart"></div>
<div id="overlay" class="overlay"></div>
<div id="toast-notification" class="toast-notification"></div>

<script src="./js/carrinho.js"></script>
</body>
</html>