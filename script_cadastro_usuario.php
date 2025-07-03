<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

    $nome  = $_POST['nome'] ?? '';
    $idade = $_POST['idade'] ?? null;
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($nome) || empty($idade) || empty($email) || empty($senha)) {
        echo "Erro: Por favor, preencha todos os campos.";
        exit;
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $foto = $_FILES['foto'];
    $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($extensao, $extensoes_permitidas)) {
        echo "Erro: Tipo de arquivo inválido.";
        exit;
    }

    $consulta = $con->prepare("SELECT COUNT(*) FROM tbusuario WHERE emailUsuario = ?");
    $consulta->bindParam(1, $email);
    $consulta->execute();
    if ($consulta->fetchColumn() > 0) {
        echo "Erro: Este e-mail já está cadastrado.";
        exit;
    }

    $pasta_upload = 'uploads/';
    $contador = 1;
    do {
        $novo_nome_foto = "foto" . $contador . "." . $extensao;
        $caminho_foto = $pasta_upload . $novo_nome_foto;
        $contador++;
    } while (file_exists($caminho_foto));

    if (move_uploaded_file($foto['tmp_name'], $caminho_foto)) {
        try {
            $comando = "INSERT INTO tbusuario (nomeUsuario, idadeUsuario, emailUsuario, senhaUsuario, foto) VALUES (?, ?, ?, ?, ?)";
            $stmt = $con->prepare($comando);
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(2, $idade);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $senha_hash);
            $stmt->bindParam(5, $novo_nome_foto);
            $stmt->execute();

            echo "<!DOCTYPE html>
            <html lang='pt-BR'>
            <head>
                <meta charset='UTF-8'>
                <title>Cadastro Realizado</title>
                <link rel='stylesheet' href='./Styles/sucesso.css'>
                <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap' rel='stylesheet'>
            </head>
            <body>
                <section>
                  <div class='form-box'>
                    <h1>Cadastro realizado com sucesso!</h1>
                    <p>Você será redirecionado para o login em <span id='countdown'>5</span> segundos.</p>
                  </div>
                </section>

                <script>
                    let segundos = 5;
                    const timer = setInterval(() => {
                        segundos--;
                        document.getElementById('countdown').textContent = segundos;
                        if (segundos === 0) {
                            clearInterval(timer);
                            window.location.href = 'login.php';
                        }
                    }, 1000);
                </script>
            </body>
            </html>";
        } catch (PDOException $erro) {
            echo "Erro ao inserir no banco: " . $erro->getMessage();
        }
    } else {
        echo "Erro ao fazer upload da foto.";
    }
} else {
    echo "Nenhuma foto enviada ou houve erro no upload.";
}
?>
