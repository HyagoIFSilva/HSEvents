<?php
require_once 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = strip_tags(trim($_POST["nome"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $assunto = strip_tags(trim($_POST["assunto"]));
    $mensagem = strip_tags(trim($_POST["mensagem"]));

    if (empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($assunto) || empty($mensagem)) {
        $_SESSION['toast'] = ['type' => 'error', 'message' => 'Por favor, preencha todos os campos corretamente.'];
        header('Location: ' . BASE_URL . 'home.php');
        exit;
    }

    $destinatario = "seu-email@exemplo.com";
    $titulo_email = "Nova mensagem do site HSEvents: $assunto";

    $corpo_email = "Você recebeu uma nova mensagem do seu site.\n\n";
    $corpo_email .= "Nome: $nome\n";
    $corpo_email .= "Email: $email\n\n";
    $corpo_email .= "Mensagem:\n$mensagem\n";

    $headers = "From: $nome <$email>";

    if (mail($destinatario, $titulo_email, $corpo_email, $headers)) {
        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Mensagem enviada com sucesso! Obrigado.'];
    } else {
        $_SESSION['toast'] = ['type' => 'error', 'message' => 'Ocorreu um erro ao enviar a mensagem.'];
    }
    
    header('Location: ' . BASE_URL . 'index.php');
    exit;
}
?>