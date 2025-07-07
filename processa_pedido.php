<?php
session_start();
include 'conexao.php';

// 1. Validações iniciais
if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['cart_data'])) {
    header('Location: checkout.php');
    exit;
}

// 2. Coleta e decodifica os dados
$idUsuario = $_SESSION['idUsuario'];
$cartData = json_decode($_POST['cart_data'], true);
$formaPagamento = $_POST['forma_pagamento'] ?? 'credito';

if (json_last_error() !== JSON_ERROR_NONE || !is_array($cartData) || empty($cartData)) {
    $_SESSION['cart_error'] = "Seu carrinho está vazio ou os dados são inválidos.";
    header('Location: checkout.php');
    exit;
}
if ($formaPagamento === 'credito') {
    if (empty($_POST['card_number']) || empty($_POST['card_name']) || empty($_POST['card_expiry']) || empty($_POST['card_cvc'])) {
        die("Erro: Por favor, preencha todos os dados do cartão de crédito.");
    }
}

try {
    // Prepara as queries uma vez fora do loop
    $stmtEvento = $con->prepare("SELECT nomeCadEvento, precoCadEvento FROM tbcadevento WHERE idCadEvento = ?");
    $stmtProduto = $con->prepare("SELECT nomeProduto, precoProduto FROM tbprodutos WHERE idProduto = ?");

    $subtotalReal = 0;
    $carrinhoValidado = [];
    $itensInvalidosEncontrados = false;

    foreach ($cartData as $item) {
        $itemId = $item['id'];
        $quantidade = (int) $item['quantity'];
        
        if ($quantidade <= 0) {
            $itensInvalidosEncontrados = true;
            continue;
        }

        $itemPrice = 0;
        $idParaSalvar = 0;
        $tipoDoItem = '';

        if (strpos($itemId, 'evt-') === 0) {
            $tipoDoItem = 'evento';
            $idParaSalvar = (int) preg_replace('/[^0-9]/', '', $itemId);
            $stmtEvento->execute([$idParaSalvar]);
            $itemDoBanco = $stmtEvento->fetch(PDO::FETCH_ASSOC);

            if ($itemDoBanco) {
                $itemPrice = (float) $itemDoBanco['precoCadEvento'];
            }
        } elseif (strpos($itemId, 'prod-') === 0) {
            $tipoDoItem = 'produto';
            $idParaSalvar = (int) preg_replace('/[^0-9]/', '', $itemId);
            $stmtProduto->execute([$idParaSalvar]);
            $itemDoBanco = $stmtProduto->fetch(PDO::FETCH_ASSOC);

            if ($itemDoBanco) {
                $itemPrice = (float) $itemDoBanco['precoProduto'];
            }
        }

        if ($itemPrice > 0) {
            $subtotalReal += $itemPrice * $quantidade;
            $carrinhoValidado[] = ['id' => $idParaSalvar, 'tipo' => $tipoDoItem, 'preco' => $itemPrice, 'qtd' => $quantidade];
        } else {
            $itensInvalidosEncontrados = true;
        }
    }

    if ($itensInvalidosEncontrados || empty($carrinhoValidado)) {
        $_SESSION['cart_error'] = "Erro: Um ou mais itens no seu carrinho não estão mais disponíveis. Por favor, revise seu carrinho.";
        header('Location: checkout.php');
        exit();
    }

    $valorTotalFinal = $subtotalReal;
    if ($formaPagamento === 'pix' || $formaPagamento === 'boleto') {
        $valorTotalFinal = $subtotalReal * 0.90;
    }

    $con->beginTransaction();

    $sqlPedido = "INSERT INTO tbpedidos (idUsuario, valorTotal, formaPagamento) VALUES (?, ?, ?)";
    $stmtPedido = $con->prepare($sqlPedido);
    $stmtPedido->execute([$idUsuario, $valorTotalFinal, $formaPagamento]);
    $idPedido = $con->lastInsertId();

    $sqlItem = "INSERT INTO tbpedidos_itens (idPedido, idCadEvento, idProduto, quantidade, precoUnitario) VALUES (?, ?, ?, ?, ?)";
    $stmtItem = $con->prepare($sqlItem);

    foreach ($carrinhoValidado as $item) {
        $idEvento = ($item['tipo'] == 'evento') ? $item['id'] : null;
        $idProduto = ($item['tipo'] == 'produto') ? $item['id'] : null;
        
        $stmtItem->execute([
            $idPedido,
            $idEvento,
            $idProduto,
            $item['qtd'],
            $item['preco']
        ]);
    }

    $con->commit();

    $_SESSION['pedido_confirmado_id'] = $idPedido;
    header('Location: pedido_confirmado.php');
    exit;

} catch (Exception $e) {
    if ($con->inTransaction()) {
        $con->rollBack();
    }
    error_log("Erro em processa_pedido.php: " . $e->getMessage());
    die("Desculpe, ocorreu um erro inesperado ao processar seu pedido. Por favor, tente novamente mais tarde.");
}
?>