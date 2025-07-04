<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Eventos Gamer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="./Styles/home.css"/>
  <link rel="stylesheet" href="./Styles/carrinho.css"/> 
</head>
<body>

  <header class="navbar">
    <div class="navbar-logo">
      <img src="./img/logo.png" alt="Logo" width="60" height="60">
    </div>
    <nav class="navbar-links">
      <a href="./cadastro.php">Registrar</a>
      <a href="./login.php">Login</a>
      <a href="./galeria.php">Galeria</a>
      <a href="#" id="cart-icon" class="cart-icon" style="display: none;">
        <i class="fas fa-shopping-cart"></i>
        <span id="cart-count">0</span>
      </a>
    </nav>
  </header>

  <section class="video-section fade-in">
    <video autoplay muted loop playsinline>
      <source src="./img/BGS 2024 - Viva O Game.mp4" type="video/mp4" />
      Seu navegador não suporta vídeo.
    </video>
  </section>

  <section class="cards-parceiros fade-in">
    <h2>🤝 Parceiros</h2>
    <div class="cards-container">
      <a href="https://www.ccxp.com.br" class="partner-card" target="_blank">
        <img src="./img/ccxp.png" alt="CCXP">
      </a>
      <a href="https://www.gamescom.global" class="partner-card" target="_blank">
        <img src="./img/gamescom.png" alt="Gamescom">
      </a>
      <a href="https://www.brasilgameshow.com.br" class="partner-card" target="_blank">
        <img src="./img/BGS.png" alt="BGS">
      </a>
    </div>
  </section>


  <section class="hoteis fade-in">
    <h2>🏨 Hotéis</h2>
    <div class="hotel-card">
      <img src="./img/charlie.jpg" alt="Hotel 1" />
      <div class="hotel-info">
        <h3>CHARLIE</h3>
        <p>📍 Jardim Paulista</p>
        <p>🚶 9.3 KM • 📶 Wi-Fi • ❄️ Ar-condicionado</p>
        <p>Descubra uma nova forma de se hospedar com conforto, praticidade e zero burocracia.</p>
      </div>
      <div class="hotel-btn">
        <a href="#" target="_blank">RESERVE AGORA</a>
      </div>
    </div>
    <div class="hotel-card">
      <img src="./img/289305619.jpg" alt="Hotel 2" />
      <div class="hotel-info">
        <h3>VILA GALÉ PAULISTA</h3>
        <p>📍 Consolação</p>
        <p>🚶 9 KM • 📶 Wi-Fi • ❄️ Ar-condicionado • 🅿 Estacionamento • ☕ Café da manhã</p>
        <p>Localizado próximo à Paulista, ideal para quem procura animação noturna e localização privilegiada.</p>
      </div>
      <div class="hotel-btn">
        <a href="#" target="_blank">RESERVE AGORA</a>
      </div>
    </div>
  </section>

  <section class="produtos-section reveal">
    <h2>🛒 Produtos Oficiais</h2>
    <div class="produtos-container">
      <div class="produto-card">
        <h3>Camisa Oficial</h3>
        <img src="./img/camisas.png" alt="Camisa">
        <p>Design personalizado para gamers. 100% algodão.</p>
        <span class="preco">R$ 99</span>
        <button class="comprar-btn" data-id="prod-1" data-nome="Camisa Oficial" data-preco="99.00" data-img="./img/camisas.png">COMPRAR +</button>
      </div>
      <div class="produto-card">
        <h3>Copo Gamer</h3>
        <img src="./img/copos.png" alt="Copo">
        <p>Resistente, estiloso e perfeito para maratonas.</p>
        <span class="preco">R$ 50</span>
        <button class="comprar-btn" data-id="prod-2" data-nome="Copo Gamer" data-preco="50.00" data-img="./img/copos.png">COMPRAR +</button>
      </div>
      <div class="produto-card">
        <h3>Controle Custom</h3>
        <img src="./img/controles.png" alt="Controle">
        <p>Alto desempenho e visual exclusivo.</p>
        <span class="preco">R$ 199</span>
        <button class="comprar-btn" data-id="prod-3" data-nome="Controle Custom" data-preco="199.00" data-img="./img/controles.png">COMPRAR +</button>
      </div>
    </div>
  </section>

  <footer class="footer-xtyle reveal">
    <div class="footer-row">
      <div class="footer-col">
        <h3 class="logo-text">Sobre Mim</h3>
        <p>Desenvolvedor Full-Stack Júnior
        Apaixonado por código e soluções criativas.</p>
      </div>
      <div class="footer-col">
        <h4>Office</h4>
        <p>Minha Casa</p>
        <p>My House</p>
        <p>ma maison</p>
        <p class="footer-email">Hyagodw32@outlook.com</p>
        <h4>+11 985364228</h4>
      </div>
      <div class="footer-col">
        <h4>Links</h4>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Features</a></li>
            <li><a href="#">Contacts</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Newsletter</h4>
        <form class="newsletter-form">
            <i class="far fa-envelope icon-email"></i>
            <input type="email" placeholder="Digite seu email.." required>
            <button type="submit"><i class="fas fa-arrow-right"></i></button>
        </form>
        <div class="social-icons-xtyle">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-whatsapp"></i></a>
            <a href="#"><i class="fab fa-pinterest"></i></a>
        </div>
      </div>
    </div>
    <hr>
    <p class="copyright">Hyago IFsilva © 2025</p>
  </footer>

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

  <script src="./js/home.js"></script>
  <script src="./js/carrinho.js"></script>
</body>
</html>