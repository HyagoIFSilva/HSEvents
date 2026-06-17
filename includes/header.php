<?php
require_once __DIR__ . '/../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isActive($pageName) {

    if (basename($_SERVER['PHP_SELF']) == $pageName) {
        echo 'class="active"';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $page_title ?? 'Eventos Gamer'; ?></title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>Styles/main.css"/> 
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>Styles/carrinho.css"/> 
</head>
<body>

<header class="navbar">
    <div class="navbar-container">
        <a href="<?php echo BASE_URL; ?>index.php" class="navbar-logo">
            <img src="<?php echo BASE_URL; ?>img/logo1.png" alt="Logo">
        </a>
        
        <nav class="navbar-links">
            <a href="<?php echo BASE_URL; ?>index.php" <?php isActive('index.php'); ?>>Home</a>
            <a href="<?php echo BASE_URL; ?>galeria.php" <?php isActive('galeria.php'); ?>>Galeria</a> 
            
            <?php if (isset($_SESSION['idUsuario'])): ?>
                <a href="<?php echo BASE_URL; ?>dashboard.php" <?php isActive('dashboard.php'); ?>>Dashboard</a>
                <a href="#" id="cart-icon" class="cart-icon" style="display: none;">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count">0</span>
                </a>
                <a href="<?php echo BASE_URL; ?>actions/logout.php">Sair</a>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>login.php" <?php isActive('login.php'); ?>>Login</a>
                <a href="<?php echo BASE_URL; ?>cadastro.php" <?php isActive('cadastro.php'); ?>>Registrar</a>
            <?php endif; ?>
        </nav>

        <button class="navbar-toggle" aria-label="Abrir menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<main>