<?php 
    require_once 'config/config.php';
    $page_title = "Cadastro"; 
    include 'includes/header.php';

    if (isset($_SESSION['idUsuario'])) {
        header('Location: ' . BASE_URL . 'dashboard.php');
        exit();
    }
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>Styles/auth.css"/> 

<section class="auth-section">
    <div class="form-box">
         <div class="form-content">
            <form action="actions/processa_cadastro.php" method="POST" enctype="multipart/form-data">
                <h2>Cadastro</h2>
                
                <?php 
                if(isset($_SESSION['register_error'])) {
                    echo '<div class="login-message error">' . $_SESSION['register_error'] . '</div>';
                    unset($_SESSION['register_error']);
                }
                ?>
            
                <div class="inputbox">
                    <ion-icon name="person-outline"></ion-icon>
                    <input type="text" name="nomeUsuario" required>
                    <label>Nome Completo</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" name="emailUsuario" required>
                    <label>E-mail</label>
                </div>
                 <div class="inputbox">
                    <ion-icon name="calendar-outline"></ion-icon>
                    <input type="number" name="idadeUsuario" required>
                    <label>Idade</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="senhaUsuario" required>
                    <label>Senha</label>
                </div>

                <div class="image-upload-group">
                    <div class="image-preview-container">
                        <img src="" id="image-preview" alt="Preview da sua imagem">
                        <span id="preview-placeholder"><ion-icon name="image-outline"></ion-icon></span>
                    </div>
                    <label for="foto" class="file-label">Escolha sua foto de perfil (Opcional)</label>
                    <input type="file" name="foto" id="foto" class="file-input" accept="image/*">
                </div>
                
                <button type="submit" class="auth-button">Cadastrar</button>
                <div class="register">
                    <p>Já tem uma conta? <a href="login.php">Faça o login</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="<?php echo BASE_URL; ?>js/auth.js"></script>
<?php 
    include 'includes/footer.php'; 
?>