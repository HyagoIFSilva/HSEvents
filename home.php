<?php 
    require_once 'config.php';
    require_once 'conexao.php';

    $page_title = "Eventos Gamer - Home"; 
    include 'header.php';

    try {
        $stmtEventos = $con->query("SELECT * FROM tbcadevento WHERE dataCadEvento >= CURDATE() ORDER BY dataCadEvento ASC LIMIT 6");
        $eventos_destaque = $stmtEventos->fetchAll(PDO::FETCH_ASSOC);

        $stmtProdutos = $con->query("SELECT * FROM tbprodutos ORDER BY categoriaProduto, nomeProduto");
        $produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);
        
        $stmtParceiros = $con->query("SELECT * FROM tbparceiros");
        $parceiros = $stmtParceiros->fetchAll(PDO::FETCH_ASSOC);

        $stmtHoteis = $con->query("SELECT * FROM tbhoteis");
        $hoteis = $stmtHoteis->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $produtos = $parceiros = $eventos_destaque = $hoteis = [];
        error_log("Erro na home page: " . $e->getMessage());
    }
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>Styles/home.css"/> 

<section class="video-section">
    <div class="video-overlay"></div>
    <video autoplay muted loop playsinline><source src="<?php echo BASE_URL; ?>img/BGS 2024 - Viva O Game.mp4" type="video/mp4" /></video>
    <div class="video-content">
        <h1 class="animate-on-scroll fade-in-up">O Palco do Universo Gamer</h1>
        <p class="animate-on-scroll fade-in-up delay-1">Os maiores eventos, os melhores produtos e a paixão que nos une. Tudo em um só lugar.</p>
        <a href="<?php echo BASE_URL; ?>galeria.php" class="cta-button animate-on-scroll fade-in-up delay-2">Ver Eventos</a>
    </div>
</section>

<section class="featured-events-section animate-on-scroll fade-in-up">
    <h2>Eventos em Destaque</h2>
    <div class="featured-swiper-container">
        <div class="swiper featured-swiper">
            <div class="swiper-wrapper">
                <?php foreach ($eventos_destaque as $evento): ?>
                <div class="swiper-slide">
                    <a href="detalhes_evento.php?id=<?php echo $evento['idCadEvento']; ?>" class="event-card-home">
                        <img src="<?php echo BASE_URL . 'uploads/' . htmlspecialchars($evento['fotoCadEvento']); ?>" alt="<?php echo htmlspecialchars($evento['nomeCadEvento']); ?>" class="event-card-img">
                        <div class="event-card-overlay">
                            <h3><?php echo htmlspecialchars($evento['nomeCadEvento']); ?></h3>
                            <p><i class="fas fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($evento['dataCadEvento'])); ?></p>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>

<section class="parceiros-section">
    <div class="marquee"><div class="marquee-content">
        <?php foreach (array_merge($parceiros, $parceiros) as $parceiro): ?>
            <div class="partner-logo"><a href="<?php echo htmlspecialchars($parceiro['linkParceiro']); ?>" target="_blank"><img src="<?php echo BASE_URL . htmlspecialchars($parceiro['logoParceiro']); ?>" alt="<?php echo htmlspecialchars($parceiro['nomeParceiro']); ?>"></a></div>
        <?php endforeach; ?>
    </div></div>
</section>

<section class="sobre-nos-section animate-on-scroll">
    <div class="sobre-nos-container">
        <div class="sobre-nos-imagem">
            <img src="<?php echo BASE_URL; ?>img/robo.png" alt="Mascote HSEvents">
        </div>
        <div class="sobre-nos-texto">
            <span class="section-badge">Nossa Missão</span>
            <h2>Garantir seu Lugar na História.</h2>
            <p>Mais do que uma plataforma de ingressos, a HSEvents é a sua ponte direta para as experiências mais eletrizantes do cenário gamer e da cultura pop. Nossa missão é levar você ao coração da ação, seja nas finais mundiais de gigantes como <strong>League of Legends, Valorant e CS:GO</strong>, ou nas maiores convenções que celebram nossa paixão, como a <strong>BGS, Gamescom e CCXP</strong>.</p>
            <p>Explore, descubra e garanta seu lugar na primeira fila da história.</p>
        </div>
    </div>
</section>

<section class="testimonials-section">
    <h2 class="animate-on-scroll fade-in-up">O Que Nossos Gamers Dizem</h2>
    <div class="testimonials-grid">
        <div class="testimonial-card animate-on-scroll fade-in-up"><p>"A compra do ingresso para a final do mundial foi super rápida e segura. A HSEvents é minha plataforma número 1 agora!"</p><div class="testimonial-author">- João "JV" Pereira</div></div>
        <div class="testimonial-card animate-on-scroll fade-in-up delay-1"><p>"Finalmente um lugar que reúne todos os grandes eventos de e-sports. A cobertura da BGS foi impecável. Recomendo demais!"</p><div class="testimonial-author">- Mariana "Mary" Costa</div></div>
        <div class="testimonial-card animate-on-scroll fade-in-up delay-2"><p>"Além dos ingressos, comprei uma camisa e a qualidade é incrível. Site fácil de usar e com um design muito legal."</p><div class="testimonial-author">- Lucas "Luke" Almeida</div></div>
    </div>
</section>

<section class="hoteis">
    <h2 class="animate-on-scroll fade-in-up">🏨 Hotéis Parceiros</h2>
    <?php foreach($hoteis as $index => $hotel): ?>
    <div class="hotel-card animate-on-scroll fade-in-up delay-<?php echo $index+1; ?>">
      <img src="<?php echo BASE_URL . htmlspecialchars($hotel['imagemHotel']); ?>" alt="<?php echo htmlspecialchars($hotel['nomeHotel']); ?>" />
      <div class="hotel-info">
        <h3><?php echo htmlspecialchars($hotel['nomeHotel']); ?></h3>
        <p>📍 <?php echo htmlspecialchars($hotel['localHotel']); ?></p>
        <p class="details"><?php echo htmlspecialchars($hotel['detalhesHotel']); ?></p>
        <p class="description"><?php echo htmlspecialchars($hotel['descricaoHotel']); ?></p>
      </div>
      <div class="hotel-btn"><a href="<?php echo htmlspecialchars($hotel['linkReserva']); ?>" target="_blank" class="botao-reservar">Reserve Agora</a></div>
    </div>
    <?php endforeach; ?>
</section>

<section class="produtos-section">
    <h2 class="animate-on-scroll fade-in-up">Nossos Produtos</h2>
    <div class="produtos-swiper-container animate-on-scroll fade-in-up delay-1">
        <div class="swiper produtos-swiper">
            <div class="swiper-wrapper">
                <?php foreach ($produtos as $produto): ?>
                <div class="swiper-slide">
                    <div class="produto-card-home">
                        <div class="produto-imagem-container"><img src="<?php echo BASE_URL . htmlspecialchars($produto['imagemProduto']); ?>" alt="<?php echo htmlspecialchars($produto['nomeProduto']); ?>" class="produto-card-img"></div>
                        <div class="produto-card-body">
                            <h3><?php echo htmlspecialchars($produto['nomeProduto']); ?></h3>
                            <p class="produto-preco">R$ <?php echo number_format($produto['precoProduto'], 2, ',', '.'); ?></p>
                            <button class="comprar-btn" data-id="prod-<?php echo $produto['idProduto']; ?>" data-nome="<?php echo htmlspecialchars($produto['nomeProduto']); ?>" data-preco="<?php echo $produto['precoProduto']; ?>" data-img="<?php echo BASE_URL . htmlspecialchars($produto['imagemProduto']); ?>">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="swiper-button-next produtos-arrow"></div>
        <div class="swiper-button-prev produtos-arrow"></div>
    </div>
</section>

<?php 
    include 'footer.php'; 
?>