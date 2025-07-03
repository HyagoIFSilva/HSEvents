<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Eventos Gamer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="./Styles/home.css"/>
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
        <p>📍 Jardim Paulista - <a color="blue" href="https://www.google.com/maps/search/CHARLIE+%F0%9F%93%8D+Jardim+Paulista+-+Mostrar+no+mapa/@-23.5667449,-46.661632,15z/data=!3m1!4b1?entry=ttu&g_ep=EgoyMDI1MDUwNy4wIKXMDSoASAFQAw%3D%3D" target="_blank">Mostrar no mapa</a></p>
        <p>🚶 9.3 KM • 📶 Wi-Fi • ❄️ Ar-condicionado</p>
        <p>Descubra uma nova forma de se hospedar com conforto, praticidade e zero burocracia.</p>
      </div>
      <div class="hotel-btn">
        <a href="https://www.booking.com/searchresults.html?aid=360920&label=New_English_EN_ALL-GBIECAUS_6409071846-3U_mTqNWJowyqDkTVweKSgS217966040599%3Apl%3Ata%3Ap1%3Ap2%3Aac%3Aap%3Aneg&gclid=Cj0KCQjw_8rBBhCFARIsAJrc9yAdsT0vWgxK533O6rUvC43wFWZLYX7lUVm4JYhymWkxu1NAiEZUqzsaAi8SEALw_wcB&highlighted_hotels=10171666&redirected=1&city=-671824&hlrd=no_dates&source=hotel&expand_sb=1&keep_landing=1&sid=77c2d965f7285e465ee1f1d324faf41b" target="_blank">RESERVE AGORA</a>
      </div>
    </div>
    <div class="hotel-card">
      <img src="./img/289305619.jpg" alt="Hotel 2" />
      <div class="hotel-info">
        <h3>VILA GALÉ PAULISTA</h3>
        <p>📍 Consolação - <a href="https://www.google.com/maps/place/Vila+Gal%C3%A9+Paulista/@-23.555314,-46.6634895,17z/data=!4m9!3m8!1s0x94ce582d7e5f1629:0x570439df30252089!5m2!4m1!1i2!8m2!3d-23.555314!4d-46.6609146!16s%2Fg%2F11j4xqxn25?entry=ttu&g_ep=EgoyMDI1MDUwNy4wIKXMDSoASAFQAw%3D%3D" target="_blank">Mostrar no mapa</a></p>
        <p>🚶 9 KM • 📶 Wi-Fi • ❄️ Ar-condicionado • 🅿 Estacionamento • ☕ Café da manhã</p>
        <p>Localizado próximo à Paulista, ideal para quem procura animação noturna e localização privilegiada.</p>
      </div>
      <div class="hotel-btn">
        <a href="https://www.booking.com/searchresults.pt-br.html?aid=360920&label=New_English_EN_ALL-GBIECAUS_14224741686-KiBH2ftIzA2ASNVrtWSzjgS60966727686%3Apl%3Ata%3Ap1%3Ap2%3Aac%3Aap%3Aneg&gclid=Cj0KCQjw_8rBBhCFARIsAJrc9yAX0tPkArBlqDlAqacnKjO7GD1vVlx-Gbiwqh4Xt5TPq8_Q4JKqCvUaAq67EALw_wcB&highlighted_hotels=5939893&redirected=1&city=-671824&hlrd=no_dates&source=hotel&expand_sb=1&keep_landing=1&sid=77c2d965f7285e465ee1f1d324faf41b">RESERVE AGORA</a>
      </div>
    </div>
  </section>

  <section class="produtos-section reveal">
    <h2>🛒 Produtos Oficiais</h2>
    <div class="produtos-container">
      <div class="produto-card" data-id="1" data-nome="Camisa Oficial" data-preco="99" data-img="./img/camisas.png">
        <h3>Camisa Oficial</h3>
        <img src="./img/camisas.png" alt="Camisa">
        <p>Design personalizado para gamers. 100% algodão.</p>
        <span class="preco">R$ 99</span>
        <button class="comprar-btn">COMPRAR +</button>
      </div>
      <div class="produto-card" data-id="2" data-nome="Copo Gamer" data-preco="50" data-img="./img/copos.png">
        <h3>Copo Gamer</h3>
        <img src="./img/copos.png" alt="Copo">
        <p>Resistente, estiloso e perfeito para maratonas.</p>
        <span class="preco">R$ 50</span>
        <button class="comprar-btn">COMPRAR +</button>
      </div>
      <div class="produto-card" data-id="3" data-nome="Controle Custom" data-preco="199" data-img="./img/controles.png">
        <h3>Controle Custom</h3>
        <img src="./img/controles.png" alt="Controle">
        <p>Alto desempenho e visual exclusivo.</p>
        <span class="preco">R$ 199</span>
        <button class="comprar-btn">COMPRAR +</button>
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
                <svg class="icon-email" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <input type="email" placeholder="Digite seu email.." required>
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </button>
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
    <div id="cart-items" class="cart-items">
      </div>
    <div class="cart-footer">
      <div class="frete-section">
        <label for="cep">Qual CEP de entrega?</label>
        <div class="cep-input">
          <input type="text" id="cep" placeholder="00000-000">
          <button class="calcular-frete">CALCULAR</button>
        </div>
        <a href="#" class="nao-sei-cep">Não sei o meu CEP</a>
      </div>
      <div class="subtotal">
        <span>Subtotal</span>
        <span id="subtotal-price">R$ 0,00</span>
      </div>
      <div class="opcoes-pagamento">
          <p><i class="fas fa-credit-card"></i> 12x de <span id="parcela-price">R$ 0,00</span> s/ juros</p>
          <p class="desconto-avista">
            <i class="fas fa-barcode"></i> <span id="avista-price">R$ 0,00</span> com desconto à vista no boleto ou pix
          </p>
      </div>
      <button class="finalizar-pedido">FECHAR PEDIDO</button>
      <a href="#" id="continuar-comprando">Continuar comprando</a>
    </div>
  </div>
  <div id="overlay" class="overlay"></div>


  <script src="./js/home.js"></script>
</body>
</html>