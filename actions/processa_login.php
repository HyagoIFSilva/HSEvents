<?php
require_once __DIR__ . '/../config/config.php';
include __DIR__ . '/../config/conexao.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

$email = trim($_POST['emailUsuario'] ?? '');
$senha = trim($_POST['senhaUsuario'] ?? '');


if (empty($email) || empty($senha)) {
    $_SESSION['login_error'] = "Por favor, preencha todos os campos.";
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

try {
  
    $sql = 'SELECT idUsuario, nomeUsuario, senhaUsuario, foto FROM tbusuario WHERE emailUsuario = ?';
    $stmt = $con->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senhaUsuario'])) {
       
        session_regenerate_id(true); 
        
    
        $_SESSION['idUsuario'] = $user['idUsuario'];
        $_SESSION['nome']      = $user['nomeUsuario'];
        $_SESSION['foto']      = $user['foto'];
        
        $_SESSION['login_success'] = true;


        header('Location: ' . BASE_URL . 'login.php');
        exit();

    } else {
     
        $_SESSION['login_error'] = 'E-mail ou senha incorretos.';
        header('Location: ' . BASE_URL . 'login.php');
        exit();
    }
} catch (PDOException $e) {
    error_log("Erro de login: " . $e->getMessage());
    $_SESSION['login_error'] = 'Ocorreu um erro no servidor. Tente novamente mais tarde.';
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}