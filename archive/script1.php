<?php

include 'conexao.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

    
    $nome = $_POST['nome'] ?? '';
    $idade = $_POST['idade'] ?? null;
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

   
    if (empty($nome) || empty($idade) || empty($email) || empty($senha)) {
        echo "Erro: Por favor, preencha todos os campos.";
        exit;
    }


    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);


    $foto = $_FILES['foto'];
    $foto_nome = $foto['name'];
    $foto_temp = $foto['tmp_name'];
    $foto_tamanho = $foto['size'];


    $extensao = strtolower(pathinfo($foto_nome, PATHINFO_EXTENSION));
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($extensao, $extensoes_permitidas)) {
        echo "Erro: Tipo de arquivo inválido. Apenas JPG, JPEG, PNG e GIF são permitidos.";
        exit;
    }

    $consulta = $con->prepare("SELECT COUNT(*) FROM tbusuario WHERE emailUsuario = ?");
    $consulta->bindParam(1, $email);
    $consulta->execute();
    $existe = $consulta->fetchColumn();

    if ($existe > 0) {
        echo "Erro: Este e-mail já está cadastrado.";
        exit;
    }

    $pasta_upload = 'uploads/';

    
    $contador = 1;
    while (file_exists($pasta_upload . "foto" . $contador . "." . $extensao)) {
        $contador++;
    }
    $novo_nome_foto = "foto" . $contador . '.' . $extensao;
    $caminho_foto = $pasta_upload . $novo_nome_foto;

   
    if (move_uploaded_file($foto_temp, $caminho_foto)) {
        try {
            
            $comando = "INSERT INTO tbusuario (nomeUsuario, emailUsuario, senhaUsuario, foto) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($comando);
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $senha_hash);
            $stmt->bindParam(5, $novo_nome_foto);

            $stmt->execute();

          
            echo "<!DOCTYPE html>
            <html lang='pt-BR'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Cadastro Realizado</title>
                <link rel='stylesheet' type='text/css' href='css/criarCadastro.css'>
            </head>
            <body>
                <div class='fundo'> 
                    <header class='header'>
                        <a href='./Home.html'><img class='logo' src='./img/logo.png' alt='Logo'></a>
                        <div class='navbar'>
                            <nav>
                                <ul class='Navegacao'>
                                    <a href='Home.html'>Home</a>
                                    <a href='galeria.html'>Galeria</a>
                                    <a href='cadastro.html'>Cadastro</a>
                                    <a href='login.html'>Login</a>
                                </ul>
                            </nav>
                        </div>
                    </header>
                    <div class='black'>
                        <div class='container'>
                            <div class='message'>
                                <h1>Cadastro realizado com sucesso!</h1>
                                <p>Você será redirecionado para a página de login em 10 segundos.</p>
                                <p class='timer' id='countdown'>10</p>
                            </div>
                            <script>
                                let countdown = 10;
                                let timer = setInterval(function() {
                                    countdown--;
                                    document.getElementById('countdown').textContent = countdown;
                                    if (countdown === 0) {
                                        clearInterval(timer);
                                        window.location.href = 'login.php';
                                    }
                                }, 1000);
                            </script>
                        </div>
                    </div>
                </div>
                <footer>
                    <p>© 2025 BK Eventos | All Rights Reserved</p>
                </footer>
            </body>
            </html>";

        } catch (PDOException $erro) {
            echo "Erro ao inserir no banco: " . $erro->getMessage();
        }
    } else {
        echo "Erro ao fazer o upload da foto.";
    }

} else {
    echo "Nenhuma foto foi selecionada ou houve erro no upload.";
}
?>

