<?php
require_once 'config.php';
include 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'cadastro.php');
    exit();
}


$nome = trim($_POST['nomeUsuario'] ?? '');
$email = trim($_POST['emailUsuario'] ?? '');
$senha = trim($_POST['senhaUsuario'] ?? '');
$idade = trim($_POST['idadeUsuario'] ?? null);

if (empty($nome) || empty($email) || empty($senha) || empty($idade)) {
    $_SESSION['register_error'] = "Por favor, preencha todos os campos.";
    header('Location: ' . BASE_URL . 'cadastro.php');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_error'] = "Formato de e-mail inválido.";
    header('Location: ' . BASE_URL . 'cadastro.php');
    exit();
}

$stmt = $con->prepare('SELECT idUsuario FROM tbusuario WHERE emailUsuario = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    $_SESSION['register_error'] = "Este e-mail já está cadastrado.";
    header('Location: ' . BASE_URL . 'cadastro.php');
    exit();
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);
$nomeFoto = 'default.png'; 

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $foto = $_FILES['foto'];
    $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (in_array($extensao, $permitidas)) {
    
        $nomeFoto = uniqid('user_') . '.' . $extensao;
        $caminhoUpload = 'uploads/' . $nomeFoto;
        move_uploaded_file($foto['tmp_name'], $caminhoUpload);
    }
}

try {
    $sql = "INSERT INTO tbusuario (nomeUsuario, emailUsuario, senhaUsuario, idadeUsuario, foto) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->execute([$nome, $email, $senhaHash, $idade, $nomeFoto]);

    $_SESSION['login_message'] = "Cadastro realizado com sucesso! Faça o login.";
    header('Location: ' . BASE_URL . 'login.php');
    exit();

} catch (PDOException $e) {
    error_log("Erro de cadastro: " . $e->getMessage());
    $_SESSION['register_error'] = "Ocorreu um erro ao criar sua conta. Tente novamente.";
    header('Location: ' . BASE_URL . 'cadastro.php');
    exit();
}