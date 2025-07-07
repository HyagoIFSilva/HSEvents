</main>

<div id="toast-container"></div>

<footer class="footer-xtyle reveal">
    <div class="footer-row">
        <div class="footer-col">
            <h3 class="logo-text">Sobre Mim</h3>
            <p>Desenvolvedor Full-Stack Júnior Apaixonado por código e soluções criativas.</p>
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

<div id="sidebar-cart" class="sidebar-cart"></div>
<div id="overlay" class="overlay"></div>

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

    setTimeout(() => {
        toast.classList.add('show');
    }, 100);

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