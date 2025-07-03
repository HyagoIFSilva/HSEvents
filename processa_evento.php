    <?php
    session_start();
    include 'conexao.php';

    if (!isset($_SESSION['idUsuario'])) {
        header('Location: login.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'
        && isset($_FILES['fotoCadEvento'])
        && $_FILES['fotoCadEvento']['error'] == 0) {

        $titulo      = $_POST['nomeCadEvento'];
        $data_evento = $_POST['dataCadEvento'];
        $descricao   = $_POST['descCadEvento'];

        $imagem    = $_FILES['fotoCadEvento'];
        $nome_img  = $imagem['name'];
        $temp_img  = $imagem['tmp_name'];

        $extensao   = strtolower(pathinfo($nome_img, PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];

        if (!in_array($extensao, $permitidas)) {
            $_SESSION['msg_erro'] = "Erro: Formato de imagem inválido.";
            header('Location: cadastrar_evento.php');
            exit();
        }

        $pasta     = 'uploads/';
        $contador  = 1;

        foreach (glob($pasta . "evento*.*") as $arquivo) {
            if (preg_match('/evento(\d+)\./', basename($arquivo), $m)) {
                $contador = max($contador, (int)$m[1] + 1);
            }
        }

        $nome_final    = "evento{$contador}.{$extensao}";
        $caminho_final = $pasta . $nome_final;

        if (move_uploaded_file($temp_img, $caminho_final)) {
            try {
                $sql  = "INSERT INTO tbcadevento
                        (nomeCadEvento, dataCadEvento, descCadEvento, fotoCadEvento, idUsuario)
                        VALUES (?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->execute([$titulo, $data_evento, $descricao, $nome_final, $_SESSION['idUsuario']]);

                $_SESSION['evento_sucesso'] = true;
                header('Location: cadastrar_evento.php');
                exit();

            } catch (PDOException $e) {
                $_SESSION['msg_erro'] = "Erro ao cadastrar evento: " . $e->getMessage();
                header('Location: cadastrar_evento.php');
                exit();
            }
        } else {
            $_SESSION['msg_erro'] = "Erro ao fazer upload da imagem.";
            header('Location: cadastrar_evento.php');
            exit();
        }
    } else {
        $_SESSION['msg_erro'] = "Envie todos os campos e uma imagem válida.";
        header('Location: cadastrar_evento.php');
        exit();
    }

