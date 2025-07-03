<?php
session_start();
include 'conexao.php'; 
 
if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

 
if (!isset($_POST['idCadEvento'])) {
     
    header('Location: galeria.php');
    exit();
}

$idEvento = $_POST['idCadEvento'];
$idUsuario = $_SESSION['idUsuario'];
$caminhoUpload = 'uploads/';

try {
    
    $sql_select = "SELECT fotoCadEvento FROM tbcadevento WHERE idCadEvento = :idEvento AND idUsuario = :idUsuario";
    $stmt_select = $con->prepare($sql_select);
    $stmt_select->execute([
        ':idEvento' => $idEvento,
        ':idUsuario' => $idUsuario
    ]);
    
    $evento = $stmt_select->fetch(PDO::FETCH_ASSOC);


    if ($evento) {

        $arquivoFoto = $caminhoUpload . $evento['fotoCadEvento'];
        if (file_exists($arquivoFoto)) {
            unlink($arquivoFoto); 
        }

        
        $sql_delete = "DELETE FROM tbcadevento WHERE idCadEvento = :idEvento";
        $stmt_delete = $con->prepare($sql_delete);
        $stmt_delete->execute([':idEvento' => $idEvento]);
        
       
        $_SESSION['evento_excluido'] = "Evento excluído com sucesso!";

    } else {
       
        $_SESSION['erro_exclusao'] = "Não foi possível excluir o evento.";
    }

} catch (PDOException $e) {
   
    $_SESSION['erro_exclusao'] = "Erro ao excluir o evento: " . $e->getMessage();
}


header('Location: galeria.php');
exit();
?>