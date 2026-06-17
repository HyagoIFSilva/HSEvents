<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {

    $titulo     = trim($_POST['titulo'] ?? '');
    $data_evento= trim($_POST['data_evento'] ?? '');
    $descricao  = trim($_POST['descricao'] ?? '');

    if (empty($titulo) || empty($data_evento) || empty($descricao)) {
        $_SESSION['msg_erro'] = "Por favor, preencha todos os campos.";
        header('Location: cadastrarevento.php');
        exit;
    }

    $imagem      = $_FILES['imagem'];
    $nome_imagem = $imagem['name'];
    $tmp_imagem  = $imagem['tmp_name'];
    $tamanho_imagem = $imagem['size'];

    $extensao = strtolower(pathinfo($nome_imagem, PATHINFO_EXTENSION));
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($extensao, $extensoes_permitidas)) {
        $_SESSION['msg_erro'] = "Tipo de arquivo inválido. Apenas JPG, JPEG, PNG e GIF são permitidos.";
        header('Location: cadastrarevento.php');
        exit;
    }

    $consulta = $con->prepare("SELECT COUNT(*) FROM tbcadevento WHERE titulo = ?");
    $consulta->execute([$titulo]);
    $existe = $consulta->fetchColumn();

    if ($existe > 0) {
        $_SESSION['msg_erro'] = "Este título de evento já está cadastrado.";
        header('Location: cadastrarevento.php');
        exit;
    }

    $pasta_upload = 'uploads/';

   
    $contador = 1;
    do {
        $novo_nome = "evento_" . time() . "_" . $contador . "." . $extensao;
        $caminho_imagem = $pasta_upload . $novo_nome;
        $contador++;
    } while (file_exists($caminho_imagem));

    if (move_uploaded_file($tmp_imagem, $caminho_imagem)) {
        try {
            
            $comando = "INSERT INTO tbcadevento (titulo, data_evento, descricao, imagem) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($comando);
            $stmt->execute([$titulo, $data_evento, $descricao, $novo_nome]);

            $_SESSION['msg_sucesso'] = "Evento cadastrado com sucesso!";
            header('Location: cadastrarevento.php');
            exit;
        } catch (PDOException $e) {
            $_SESSION['msg_erro'] = "Erro ao inserir no banco: " . $e->getMessage();
            header('Location: cadastrarevento.php');
            exit;
        }
    } else {
        $_SESSION['msg_erro'] = "Erro ao fazer o upload da imagem.";
        header('Location: cadastrarevento.php');
        exit;
    }

} else {
    $_SESSION['msg_erro'] = "Nenhuma imagem foi selecionada ou houve erro no upload.";
    header('Location: cadastrarevento.php');
    exit;
}
?>

