<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: galeria.php');
    exit;
}

$idCadEvento = $_POST['idCadEvento'] ?? 0;
$nome = trim($_POST['nome'] ?? '');
$data = trim($_POST['data'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$fotoAntiga = $_POST['fotoAntiga'] ?? '';
$idUsuario = $_SESSION['idUsuario'];
$nomeFotoNova = $fotoAntiga;

if (isset($_FILES['foto_evento']) && $_FILES['foto_evento']['error'] === UPLOAD_ERR_OK) {
    $imagem = $_FILES['foto_evento'];
    $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($extensao, $extensoes_permitidas)) {
        $novo_nome_arquivo = "evento_" . uniqid() . "." . $extensao;
        $caminho_upload = 'uploads/' . $novo_nome_arquivo;

        if (move_uploaded_file($imagem['tmp_name'], $caminho_upload)) {
            if ($fotoAntiga && file_exists('uploads/' . $fotoAntiga)) {
                unlink('uploads/' . $fotoAntiga);
            }
            $nomeFotoNova = $novo_nome_arquivo;
        }
    }
}

try {
    $sql = "UPDATE tbcadevento SET 
                nomeCadEvento = ?, 
                dataCadEvento = ?, 
                descCadEvento = ?, 
                fotoCadEvento = ?
            WHERE idCadEvento = ? AND idUsuario = ?";

    $stmt = $con->prepare($sql);
    $stmt->execute([$nome, $data, $descricao, $nomeFotoNova, $idCadEvento, $idUsuario]);

    $_SESSION['evento_editado'] = "Evento atualizado com sucesso!";
    header('Location: galeria.php');
    exit;

} catch (PDOException $e) {
    $_SESSION['msg_erro'] = "Erro ao atualizar o banco de dados: " . $e->getMessage();
    header('Location: editar_evento.php?id=' . $idCadEvento);
    exit;
}