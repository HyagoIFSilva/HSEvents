<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['idUsuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $nome = $_POST['nome'] ?? '';
    $data = $_POST['data'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $fotoAntiga = $_POST['fotoAntiga'] ?? '';


    if (empty($nome) || empty($data) || empty($descricao)) {
        echo "Preencha todos os campos.";
        exit;
    }

    $novaFotoNome = $fotoAntiga; 

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];
        $fileSize = $_FILES['foto']['size'];
        $fileType = $_FILES['foto']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif' , 'jfif'];

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
            echo "Tipo de arquivo não permitido. Apenas jpg, jpeg, png e gif.";
            exit;
        }
    }

    if (empty($_POST['idCadEvento'])) {
        echo "ID do evento não informado.";
        exit;
    }
    $idEvento = $_POST['idCadEvento'];

    $sql = "UPDATE tbcadevento SET 
                nomeCadEvento = ?,
                dataCadEvento = ?,
                descCadEvento = ?,
                fotoCadEvento = ?
            WHERE idUsuario = ? AND idCadEvento = ?";

    $stmt = $con->prepare($sql);
    $resultado = $stmt->execute([$nome, $data, $descricao, $novaFotoNome, $usuario_id, $idEvento]);

    if ($resultado) {
        header('Location: galeria.php?msg=editado');
        exit();
    } else {
        echo "Erro ao atualizar evento.";
        exit;
    }
} else {
    echo "Método inválido.";
    exit;
}
?>

