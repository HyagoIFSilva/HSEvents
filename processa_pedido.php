<?php
session_start();
include 'conexao.php';

// 1. Validação inicial
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

// 3. Verifica se o carrinho é válido
if (json_last_error() !== JSON_ERROR_NONE || !is_array($cartData) || empty($cartData)) {
    $_SESSION['cart_error'] = "Seu carrinho está vazio ou os dados são inválidos.";
    header('Location: checkout.php');
    exit;
}

// 4. Valida campos de cartão de crédito, se necessário
if ($formaPagamento === 'credito') {
    if (empty($_POST['card_number']) || empty($_POST['card_name']) || empty($_POST['card_expiry']) || empty($_POST['card_cvc'])) {
        die("Erro: Por favor, preencha todos os dados do cartão de crédito.");
    }
}

// 5. Bloco de segurança para validar a integridade do carrinho
try {
    $idsEventos = [];
    foreach ($cartData as $item) {
        // --- CORREÇÃO DEFINITIVA APLICADA AQUI ---
        // Usamos preg_replace para pegar APENAS os dígitos e ignorar o sinal de menos ('-').
        $idsEventos[] = (int) preg_replace('/[^0-9]/', '', $item['id']);
    }

    if (!empty($idsEventos)) {
        $placeholders = implode(',', array_fill(0, count($idsEventos), '?'));
        
        $sqlVerifica = "SELECT COUNT(*) FROM tbcadevento WHERE idCadEvento IN ($placeholders)";
        $stmtVerifica = $con->prepare($sqlVerifica);
        $stmtVerifica->execute($idsEventos);
        $countEventosExistentes = $stmtVerifica->fetchColumn();

        if ($countEventosExistentes < count($idsEventos)) {
            $_SESSION['cart_error'] = "Erro: Um ou mais eventos no seu carrinho não estão mais disponíveis. Por favor, revise seu carrinho e tente novamente.";
            header('Location: checkout.php');
            exit();
        }
    }
} catch (Exception $e) {
    die("Erro de sistema ao verificar os itens do carrinho: " . $e->getMessage());
}

// 6. Calcula o valor total do pedido
$subtotal = 0;
foreach ($cartData as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

$valorTotalFinal = $subtotal;
if ($formaPagamento === 'pix' || $formaPagamento === 'boleto') {
    $valorTotalFinal = $subtotal * 0.90;
}

// 7. Processa o pedido no banco de dados
try {
    $con->beginTransaction();

    $sqlPedido = "INSERT INTO tbpedidos (idUsuario, valorTotal, formaPagamento) VALUES (?, ?, ?)";
    $stmtPedido = $con->prepare($sqlPedido);
    $stmtPedido->execute([$idUsuario, $valorTotalFinal, $formaPagamento]);
    $idPedido = $con->lastInsertId();

    $sqlItem = "INSERT INTO tbpedidos_itens (idPedido, idCadEvento, quantidade, precoUnitario) VALUES (?, ?, ?, ?)";
    $stmtItem = $con->prepare($sqlItem);

    foreach ($cartData as $item) {
        // A mesma correção aqui para garantir consistência ao salvar no banco.
        $idEventoNumerico = (int) preg_replace('/[^0-9]/', '', $item['id']);
        $stmtItem->execute([
            $idPedido,
            $idEventoNumerico,
            $item['quantity'],
            $item['price']
        ]);
    }

    $con->commit();

    $_SESSION['pedido_confirmado_id'] = $idPedido;
    header('Location: pedido_confirmado.php');
    exit;

} catch (Exception $e) {
    $con->rollBack();
    die("Erro ao processar o pedido: " . $e->getMessage());
}