<?php
require_once 'config.php';
include 'conexao.php';
session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['idCadEvento'])) {
    header('Location: ' . BASE_URL . 'galeria.php');
    exit();
}

$idEvento = $_POST['idCadEvento'];
$idUsuario = $_SESSION['idUsuario'];

try {
    $stmt = $con->prepare("SELECT fotoCadEvento FROM tbcadevento WHERE idCadEvento = ? AND idUsuario = ?");
    $stmt->execute([$idEvento, $idUsuario]);
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($evento) {
        $stmtDelete = $con->prepare("DELETE FROM tbcadevento WHERE idCadEvento = ? AND idUsuario = ?");
        if ($stmtDelete->execute([$idEvento, $idUsuario])) {
            
          
            $caminhoImagem = 'uploads/' . $evento['fotoCadEvento'];
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }

            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => 'Evento excluído com sucesso!'
            ];
        }
    } else {
  
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => 'Erro: Você não tem permissão para excluir.'
        ];
    }

} catch (PDOException $e) {
    error_log("Erro ao excluir evento: " . $e->getMessage());
    $_SESSION['toast'] = [
        'type' => 'error',
        'message' => 'Ocorreu um erro no servidor.'
    ];
}

header('Location: ' . BASE_URL . 'galeria.php');
exit();