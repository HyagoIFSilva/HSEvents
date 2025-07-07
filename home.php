<?php 
    require_once 'config.php';
    include 'conexao.php'; // Incluindo a conexão com o banco

    // Busca os produtos do banco de dados para a seção "Produtos Oficiais"
    try {
        $stmt = $con->query("SELECT idProduto, nomeProduto, precoProduto, imagemProduto FROM tbprodutos ORDER BY idProduto ASC LIMIT 3");
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Em caso de erro, define produtos como um array vazio para não quebrar a página
        $produtos = [];
        error_log("Erro ao buscar produtos: " . $e->getMessage());
    }

    $page_title = "Eventos Gamer - Home"; 
    include 'header.php'; 
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>Styles/home.css"/> 

<section class="video-section fade-in">
    <video autoplay muted loop playsinline>
      <source src="<?php echo BASE_URL; ?>img/BGS 2024 - Viva O Game.mp4" type="video/mp4" />
      Seu navegador não suporta vídeo.
    </video>
</section>

<section class="cards-parceiros fade-in">
    <h2>🤝 Parceiros</h2>
    <div class="cards-container">
      <a href="https://www.ccxp.com.br" class="partner-card" target="_blank">
        <img src="<?php echo BASE_URL; ?>img/ccxp.png" alt="CCXP">
      </a>
      <a href="https://www.gamescom.global" class="partner-card" target="_blank">
        <img src="<?php echo BASE_URL; ?>img/gamescom.png" alt="Gamescom">
      </a>
      <a href="https://www.brasilgameshow.com.br" class="partner-card" target="_blank">
        <img src="<?php echo BASE_URL; ?>img/BGS.png" alt="BGS">
      </a>
    </div>
</section>

<section class="hoteis fade-in">
    <h2>🏨 Hotéis</h2>
    <div class="hotel-card">
      <img src="<?php echo BASE_URL; ?>img/charlie.jpg" alt="Hotel 1" />
      <div class="hotel-info">
        <h3>CHARLIE</h3>
        <p>📍 Jardim Paulista</p>
        <p class="details">🚶 9.3 KM • 📶 Wi-Fi • ❄️ Ar-condicionado</p>
        <p class="description">Descubra uma nova forma de se hospedar com conforto, praticidade e zero burocracia.</p>
      </div>
      <div class="hotel-btn">
        <a href="#" target="_blank" class="botao-reservar">RESERVE AGORA</a>
      </div>
    </div>
    <div class="hotel-card">
      <img src="<?php echo BASE_URL; ?>img/289305619.jpg" alt="Hotel 2" />
      <div class="hotel-info">
        <h3>VILA GALÉ PAULISTA</h3>
        <p>📍 Consolação</p>
        <p class="details">🚶 9 KM • 📶 Wi-Fi • ❄️ Ar-condicionado • 🅿 Estacionamento • ☕ Café da manhã</p>
        <p class="description">Localizado próximo à Paulista, ideal para quem procura animação noturna e localização privilegiada.</p>
      </div>
      <div class="hotel-btn">
        <a href="#" target="_blank" class="botao-reservar">RESERVE AGORA</a>
      </div>
    </div>
</section>

<section class="produtos-section reveal">
    <h2>🛒 Produtos Oficiais</h2>
    <div class="produtos-container">
        <?php foreach ($produtos as $produto): ?>
            <div class="produto-card">
                <h3><?php echo htmlspecialchars($produto['nomeProduto']); ?></h3>
                <img src="<?php echo BASE_URL . htmlspecialchars($produto['imagemProduto']); ?>" alt="<?php echo htmlspecialchars($produto['nomeProduto']); ?>">
                <p>Item oficial da nossa loja.</p>
                <span class="preco">R$ <?php echo number_format($produto['precoProduto'], 2, ',', '.'); ?></span>
                <button class="comprar-btn" 
                        data-id="prod-<?php echo $produto['idProduto']; ?>" 
                        data-nome="<?php echo htmlspecialchars($produto['nomeProduto']); ?>" 
                        data-preco="<?php echo $produto['precoProduto']; ?>" 
                        data-img="<?php echo BASE_URL . htmlspecialchars($produto['imagemProduto']); ?>">
                    COMPRAR +
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php 
    include 'footer.php'; 
?>