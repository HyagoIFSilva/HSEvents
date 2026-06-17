<?php
session_start();
include 'config/conexao.php';

$page_title = "Meus Pedidos";
include 'includes/header_dashboard.php'; 

try {
    $sql = "SELECT * FROM tbpedidos WHERE idUsuario = ? ORDER BY dataPedido DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute([$_SESSION['idUsuario']]);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar pedidos: " . $e->getMessage());
}
?>
<h1>Meus Pedidos</h1>
<p>Aqui está o histórico de todas as suas compras em nossa plataforma.</p>

<div class="pedidos-container">
    <?php if (empty($pedidos)): ?>
        <p>Você ainda não fez nenhum pedido.</p>
    <?php else: ?>
        <?php foreach ($pedidos as $pedido): ?>
            <div class="pedido-card">
                <div class="pedido-header">
                    <h3>Pedido #<?php echo $pedido['idPedido']; ?></h3>
                    <span>Data: <?php echo date('d/m/Y', strtotime($pedido['dataPedido'])); ?></span>
                    <strong>Total: R$ <?php echo number_format($pedido['valorTotal'], 2, ',', '.'); ?></strong>
                </div>
                <div class="pedido-body">
                    <h4>Itens:</h4>
                    <ul>
                        <?php
                        $stmtItens = $con->prepare("
                            SELECT i.quantidade, i.precoUnitario, e.nomeCadEvento, p.nomeProduto 
                            FROM tbpedidos_itens i
                            LEFT JOIN tbcadevento e ON i.idCadEvento = e.idCadEvento
                            LEFT JOIN tbprodutos p ON i.idProduto = p.idProduto
                            WHERE i.idPedido = ?
                        ");
                        $stmtItens->execute([$pedido['idPedido']]);
                        $itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($itens as $item) {
                            $nomeItem = $item['nomeCadEvento'] ?? $item['nomeProduto'];
                            echo '<li>' . htmlspecialchars($nomeItem) . ' (x' . $item['quantidade'] . ') - R$ ' . number_format($item['precoUnitario'], 2, ',', '.') . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer_dashboard.php'; ?>