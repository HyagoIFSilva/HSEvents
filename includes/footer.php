</main>

<div id="feedback-trigger"></div>

<div id="feedback-widget" class="feedback-widget">
    <div class="speech-bubble">
        Dúvidas ou sugestões? <strong>Fale conosco!</strong>
    </div>
    <img src="<?php echo BASE_URL; ?>img/mascote-duvida.png" alt="Mascote com dúvida" class="mascote-feedback">
</div>

<div id="contato-modal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Fale Conosco</h2>
            <button class="close-modal-btn">&times;</button>
        </div>
        <div class="modal-body">
            <form action="<?php echo BASE_URL; ?>scripts/processa_contato.php" method="POST" id="contato-form">
                <div class="form-group">
                    <label for="contato-nome">Seu Nome</label>
                    <input type="text" name="nome" id="contato-nome" required>
                </div>
                <div class="form-group">
                    <label for="contato-email">Seu E-mail</label>
                    <input type="email" name="email" id="contato-email" required>
                </div>
                <div class="form-group">
                    <label for="contato-assunto">Assunto</label>
                    <select name="assunto" id="contato-assunto">
                        <option value="Dúvida">Dúvida</option>
                        <option value="Sugestão">Sugestão</option>
                        <option value="Reportar um Erro">Reportar um Erro</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="contato-mensagem">Sua Mensagem</label>
                    <textarea name="mensagem" id="contato-mensagem" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Enviar Mensagem</button>
            </form>
        </div>
    </div>
</div>

<footer class="footer-xtyle reveal">
    <div class="footer-row">
        <div class="footer-col">
            <h3 class="logo-text">Sobre Mim</h3>
            <p>Desenvolvedor Full-Stack Júnior Apaixonado por código e soluções criativas.</p>
        </div>
        <div class="footer-col">
            <h4>Office</h4>
            <p>Minha Casa</p>
            <p class="footer-email">Hyagodw32@outlook.com</p>
            <h4>+11 985364228</h4>
        </div>
        <div class="footer-col">
            <h4>Links</h4>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
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
            </div>
        </div>
    </div>
    <hr>
    <p class="copyright">Hyago IFsilva © 2025</p>
</footer>

<div id="sidebar-cart" class="sidebar-cart"></div>
<div id="overlay" class="overlay"></div>
<div id="toast-container"></div>

<script>
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    const icon = document.createElement('i');
    icon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
    const text = document.createElement('span');
    text.textContent = message;
    toast.appendChild(icon);
    toast.appendChild(text);
    container.appendChild(toast);
    setTimeout(() => { toast.classList.add('show'); }, 100);
    setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        toast.addEventListener('transitionend', () => toast.remove());
    }, 4000);
}
<?php
if (isset($_SESSION['toast'])) {
    $toast = $_SESSION['toast'];
    echo "document.addEventListener('DOMContentLoaded', () => { showToast(" . json_encode($toast['message']) . ", " . json_encode($toast['type']) . "); });";
    unset($_SESSION['toast']);
}
?>
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>js/main.js"></script>
<script src="<?php echo BASE_URL; ?>js/carrinho.js"></script>
</body>
</html>