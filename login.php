<?php 
    require_once 'config.php';
    include 'conexao.php';
    
    $page_title = "Login"; 
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['login_success']) && $_SESSION['login_success']) {
        unset($_SESSION['login_success']);
        include 'header.php';
        echo '<link rel="stylesheet" href="' . BASE_URL . 'Styles/auth.css"/>';
        echo '<section class="auth-section">
                <div class="form-box">
                    <div class="form-content">
                        <div class="login-message success">Login efetuado com sucesso!</div>
                        <p style="text-align: center; color: #fff;">
                            Você será redirecionado para seu painel em <span id="countdown">3</span>...
                        </p>
                    </div>
                </div>
              </section>';
        
        echo '<script>
                let seconds = 3;
                const countdownElement = document.getElementById("countdown");
                const timer = setInterval(() => {
                    seconds--;
                    if(countdownElement) countdownElement.textContent = seconds;
                    if (seconds <= 0) {
                        clearInterval(timer);
                        window.location.href = "' . BASE_URL . 'dashboard.php";
                    }
                }, 1000);
              </script>';
        include 'footer.php';
        exit();
    }

    if (isset($_SESSION['idUsuario'])) {
        header('Location: ' . BASE_URL . 'dashboard.php');
        exit();
    }
    
    include 'header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>Styles/auth.css"/> 

<section class="auth-section">
    <div class="form-box">
        <div class="form-content">
            <form method="POST" action="processa_login.php">
                <h2>Login</h2>
                
                <?php 
                if(isset($_SESSION['login_error'])) {
                    echo '<div class="login-message error">' . $_SESSION['login_error'] . '</div>';
                    unset($_SESSION['login_error']);
                }
                ?>

                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" name="emailUsuario" required>
                    <label>E-mail</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="senhaUsuario" required>
                    <label>Senha</label>
                </div>
                <div class="forget">
                    <a href="#">Esqueceu a senha?</a>
                </div>
                <button type="submit" class="auth-button">Entrar</button>
                <div class="register">
                    <p>Não tem uma conta? <a href="cadastro.php">Registre-se</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<?php 
    include 'footer.php'; 
?>