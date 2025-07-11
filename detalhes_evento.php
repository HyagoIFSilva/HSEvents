<?php
    require_once 'config.php';
    require_once 'conexao.php';

    $idEvento = $_GET['id'] ?? 0;
    if (!$idEvento) {
        header('Location: ' . BASE_URL . 'galeria.php');
        exit;
    }

    try {
        $sql = "SELECT * FROM tbcadevento WHERE idCadEvento = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$idEvento]);
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$evento) {
            $_SESSION['toast'] = ['type' => 'error', 'message' => 'O evento que você tentou acessar não existe.'];
            header('Location: ' . BASE_URL . 'galeria.php');
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao buscar o evento: " . $e->getMessage());
    }
    
    $page_title = htmlspecialchars($evento['nomeCadEvento']) . " - Detalhes"; 
    include 'header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>Styles/detalhes_evento.css" />

<div class="detalhe-evento-container">
    <header class="detalhe-header" style="background-image: url('<?php echo BASE_URL . 'uploads/' . htmlspecialchars($evento['fotoCadEvento']); ?>');">
        <div class="header-overlay">
            <h1><?php echo htmlspecialchars($evento['nomeCadEvento']); ?></h1>
        </div>
    </header>

    <div class="detalhe-body">
        <div class="detalhe-conteudo">
            <h2>Sobre o Evento</h2>
            <p class="descricao-evento"><?php echo nl2br(htmlspecialchars($evento['descCadEvento'])); ?></p>
        </div>
        
        <aside class="detalhe-sidebar">
            <div class="compra-box">
                <h3>Garanta seu Ingresso</h3>
                <div class="info-line">
                    <i class="fas fa-calendar-alt"></i>
                    <span><?php echo date('d \d\e F \d\e Y', strtotime($evento['dataCadEvento'])); ?></span>
                </div>
                <hr>
                <div class="preco-line">
                    <span>Preço</span>
                    <span class="ticket-price">R$ <?php echo number_format($evento['precoCadEvento'], 2, ',', '.'); ?></span>
                </div>
                <button class="comprar-btn"
                    data-id="evt-<?php echo $evento['idCadEvento']; ?>"
                    data-nome="Ingresso: <?php echo htmlspecialchars($evento['nomeCadEvento']); ?>"
                    data-preco="<?php echo $evento['precoCadEvento']; ?>"
                    data-img="<?php echo BASE_URL . 'uploads/' . htmlspecialchars($evento['fotoCadEvento']); ?>">
                    Comprar Ingresso <i class="fas fa-ticket-alt"></i>
                </button>
            </div>
        </aside>
    </div>
</div>

<?php 
    include 'footer.php'; 
?>