<?php
require_once __DIR__ . '/../config/config.php';
session_start();
include __DIR__ . '/../config/conexao.php';

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'cadastrar_evento.php');
    exit;
}

if (!isset($_FILES['foto_evento']) || $_FILES['foto_evento']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['msg_erro'] = "Erro no upload do arquivo de imagem.";
    header('Location: ' . BASE_URL . 'cadastrar_evento.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$data = trim($_POST['data'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$idUsuario = $_SESSION['idUsuario'];
$imagem = $_FILES['foto_evento'];

if (empty($nome) || empty($data) || empty($descricao)) {
    $_SESSION['msg_erro'] = "Por favor, preencha todos os campos de texto.";
    header('Location: ' . BASE_URL . 'cadastrar_evento.php');
    exit;
}

$extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
$extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($extensao, $extensoes_permitidas)) {
    $_SESSION['msg_erro'] = "Tipo de arquivo inválido. Apenas JPG, JPEG, PNG e GIF são permitidos.";
    header('Location: ' . BASE_URL . 'cadastrar_evento.php');
    exit;
}

$novo_nome = "evento_" . uniqid() . "." . $extensao;
$caminho_upload = __DIR__ . '/../uploads/' . $novo_nome;

if (!move_uploaded_file($imagem['tmp_name'], $caminho_upload)) {
    $_SESSION['msg_erro'] = "Falha ao mover o arquivo de imagem.";
    header('Location: ' . BASE_URL . 'cadastrar_evento.php');
    exit;
}

try {
    $sql = "INSERT INTO tbcadevento (nomeCadEvento, dataCadEvento, descCadEvento, fotoCadEvento, idUsuario) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->execute([$nome, $data, $descricao, $novo_nome, $idUsuario]);

    $_SESSION['msg_sucesso'] = "Evento cadastrado com sucesso!";
    header('Location: ' . BASE_URL . 'galeria.php');
    exit;
} catch (PDOException $e) {
    if (file_exists($caminho_upload)) {
        unlink($caminho_upload);
    }
    $_SESSION['msg_erro'] = "Erro ao inserir no banco de dados: " . $e->getMessage();
    header('Location: ' . BASE_URL . 'cadastrar_evento.php');
    exit;
}