<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}


$mensagem = "Bem-vindo, " . htmlspecialchars($_SESSION['usuario']) . "! Você será redirecionado para a página principal...";
$classe = "mensagem";
$redirect = "dashboard.php"; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link rel="stylesheet" href="./Styles/mensagem.css">

<script>
  setTimeout(() => {
    window.location.href = "<?php echo $redirect; ?>";
  }, 3000);
</script>
</head>
<body>

<div class="<?php echo $classe; ?>">
  <?php echo $mensagem; ?>
</div>

</body>
</html>

