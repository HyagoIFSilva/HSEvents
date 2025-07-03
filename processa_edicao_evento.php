<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['idUsuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEvento = $_POST['idCadEvento'] ?? 0;
    $nome = $_POST['nome'] ?? '';
    $data = $_POST['data'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $fotoAntiga = $_POST['fotoAntiga'] ?? '';

    if (empty($nome) || empty($data) || empty($descricao) || empty($idEvento)) {
        echo "Erro: Todos os campos devem ser preenchidos.";
        exit;
    }

    $novaFotoNome = $fotoAntiga;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = 'uploads/';
            $destPath = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $novaFotoNome = $newFileName;
                if ($fotoAntiga && file_exists($uploadFileDir . $fotoAntiga)) {
                    unlink($uploadFileDir . $fotoAntiga);
                }
            } else {
                echo "Erro ao mover o arquivo de imagem.";
                exit;
            }
        } else {
            echo "Tipo de arquivo não permitido.";
            exit;
        }
    }

    $sql = "UPDATE tbcadevento SET 
                nomeCadEvento = ?,
                dataCadEvento = ?,
                descCadEvento = ?,
                fotoCadEvento = ?
            WHERE idCadEvento = ? AND idUsuario = ?";

    $stmt = $con->prepare($sql);
    $resultado = $stmt->execute([$nome, $data, $descricao, $novaFotoNome, $idEvento, $usuario_id]);

    if ($resultado) {
        header('Location: meus_eventos.php?msg=editado');
        exit();
    } else {
        echo "Erro ao atualizar evento no banco de dados.";
        exit;
    }
} else {
    echo "Método de requisição inválido.";
    exit;
}
?>