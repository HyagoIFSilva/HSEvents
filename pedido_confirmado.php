<?php
session_start();
require_once 'config/config.php';

if (!isset($_SESSION['pedido_confirmado_id'])) {
    header('Location: ' . BASE_URL . 'galeria.php');
    exit();
}
$idPedido = $_SESSION['pedido_confirmado_id'];
unset($_SESSION['pedido_confirmado_id']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>Styles/pedido_confirmado.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body>

    <div class="confirmation-container">
        <div class="confirmation-header">
            <i class="fas fa-check-circle success-icon"></i>
            <h1>Pedido Confirmado!</h1>
        </div>

        <div class="order-details">
            <p>Obrigado pela sua compra. Seu pedido número <strong>#<?php echo htmlspecialchars($idPedido); ?></strong> foi recebido com sucesso.</p>
        </div>
        
        <div class="confirmation-actions">
            <a href="<?php echo BASE_URL; ?>galeria.php" class="btn-confirm">Ver Mais Eventos</a>
        </div>
    </div>

    <div class="confirmation-mascot">
        <div class="speech-bubble-confirm">
            Obrigado pela sua compra! <strong>Volte sempre!</strong> 🎉
        </div>
        <img src="<?php echo BASE_URL; ?>img/mascote-joia.png" alt="Mascote Agradecendo">
    </div>

    <script>
        localStorage.removeItem('shoppingCart');
    </script>
</body>
</html>