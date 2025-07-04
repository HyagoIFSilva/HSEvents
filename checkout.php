<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    header('Location: login.php');
    exit();
}

// Pega a mensagem de erro da sessão, se existir.
$cart_error = null;
if (isset($_SESSION['cart_error'])) {
    $cart_error = $_SESSION['cart_error'];
    // Limpa a mensagem da sessão para que não apareça novamente.
    unset($_SESSION['cart_error']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pedido</title>
    <link rel="stylesheet" href="./Styles/checkout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="checkout-grid">
        <div class="form-column">
            <h1><i class="fas fa-user-shield"></i> Detalhes da Compra</h1>
            
            <?php if ($cart_error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($cart_error); ?>
                </div>
            <?php endif; ?>

            <form action="processa_pedido.php" method="POST" id="checkout-form">
                
                <div class="form-section">
                    <h2><i class="fas fa-shipping-fast"></i> Endereço de Entrega (Ingressos Digitais)</h2>
                    <p class="info-text">Seus ingressos são digitais e serão enviados para seu e-mail, mas precisamos do endereço para o cadastro da nota fiscal.</p>
                    <div class="form-group">
                        <label for="cep">CEP (preencha para buscar o endereço)</label>
                        <input type="text" id="cep" name="cep" required placeholder="00000-000">
                    </div>
                    <div class="form-grid-2-col">
                        <div class="form-group">
                            <label for="rua">Rua</label>
                            <input type="text" id="rua" name="rua" required>
                        </div>
                        <div class="form-group">
                            <label for="numero">Número</label>
                            <input type="text" id="numero" name="numero" required>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" id="bairro" name="bairro" required>
                    </div>
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" id="estado" name="estado" required>
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-money-check-alt"></i> Forma de Pagamento</h2>
                    <div class="payment-options">
                        <label>
                            <input type="radio" name="forma_pagamento" value="pix" checked>
                            <div class="payment-box"><i class="fas fa-qrcode"></i><span>Pix (-10%)</span></div>
                        </label>
                        <label>
                            <input type="radio" name="forma_pagamento" value="boleto">
                            <div class="payment-box"><i class="fas fa-barcode"></i><span>Boleto (-10%)</span></div>
                        </label>
                        <label>
                            <input type="radio" name="forma_pagamento" value="credito">
                            <div class="payment-box"><i class="fas fa-credit-card"></i><span>Cartão</span></div>
                        </label>
                    </div>

                    <div id="credit-card-info">
                        <div class="form-group">
                            <label for="card_number">Número do Cartão</label>
                            <input type="text" id="card_number" name="card_number" placeholder="0000 0000 0000 0000">
                        </div>
                        <div class="form-group">
                            <label for="card_name">Nome no Cartão</label>
                            <input type="text" id="card_name" name="card_name" placeholder="Como está escrito no cartão">
                        </div>
                        <div class="form-grid-2-col">
                            <div class="form-group">
                                <label for="card_expiry">Validade (MM/AA)</label>
                                <input type="text" id="card_expiry" name="card_expiry" placeholder="MM/AA">
                            </div>
                            <div class="form-group">
                                <label for="card_cvc">CVC</label>
                                <input type="text" id="card_cvc" name="card_cvc" placeholder="123">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="cart_data" id="cart-data-input">
                <button type="submit" class="btn-confirm">Finalizar Compra</button>
            </form>
        </div>

        <div class="summary-column">
            <h2><i class="fas fa-shopping-basket"></i> Resumo do Pedido</h2>
            <div id="order-summary"></div>
            <div class="total-section">
                <div id="subtotal-line"><span>Subtotal:</span><span id="subtotal-price">R$ 0,00</span></div>
                <div id="discount-line" style="display: none;"><span>Desconto:</span><span id="discount-amount">R$ 0,00</span></div>
                <div id="total-line"><span>Total:</span><span id="total-price">R$ 0,00</span></div>
            </div>
            <a href="galeria.php" class="btn-cancel" style="width: 100%; text-align: center; margin-top: 15px;">Cancelar</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cart = JSON.parse(localStorage.getItem('shoppingCart')) || [];
            
            // MUDANÇA 2: VERIFICAÇÃO DE CARRINHO VAZIO
            if (cart.length === 0) {
                alert("Seu carrinho está vazio! Você será redirecionado para a galeria de eventos.");
                window.location.href = 'galeria.php';
                return; // Impede a execução do resto do script
            }

            const summaryContainer = document.getElementById('order-summary');
            const subtotalPriceEl = document.getElementById('subtotal-price');
            const totalPriceEl = document.getElementById('total-price');
            const discountLineEl = document.getElementById('discount-line');
            const discountAmountEl = document.getElementById('discount-amount');
            const cartDataInput = document.getElementById('cart-data-input');
            const paymentOptions = document.querySelectorAll('input[name="forma_pagamento"]');
            const creditCardForm = document.getElementById('credit-card-info');
            const cepInput = document.getElementById('cep');
            
            let subtotal = 0;

            function calculateTotal() {
                let finalTotal = subtotal;
                let discount = 0;
                const selectedPayment = document.querySelector('input[name="forma_pagamento"]:checked').value;

                // Esconde o formulário do cartão e torna os campos não-obrigatórios por padrão
                creditCardForm.classList.remove('visible');
                const creditCardFields = creditCardForm.querySelectorAll('input');
                creditCardFields.forEach(input => input.required = false);
                
                if (selectedPayment === 'pix' || selectedPayment === 'boleto') {
                    discount = subtotal * 0.10;
                    finalTotal = subtotal - discount;
                    discountLineEl.style.display = 'flex';
                } else if (selectedPayment === 'credito') {
                    discountLineEl.style.display = 'none';
                    // Mostra o formulário do cartão e torna os campos obrigatórios
                    creditCardForm.classList.add('visible');
                    creditCardFields.forEach(input => input.required = true);
                }

                subtotalPriceEl.textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
                discountAmountEl.textContent = `- R$ ${discount.toFixed(2).replace('.', ',')}`;
                totalPriceEl.textContent = `R$ ${finalTotal.toFixed(2).replace('.', ',')}`;
            }

            // Popula o resumo do pedido
            cart.forEach(item => {
                const itemEl = document.createElement('div');
                itemEl.classList.add('summary-item');
                itemEl.innerHTML = `<span>${item.name} (x${item.quantity})</span> <span>R$ ${(item.price * item.quantity).toFixed(2).replace('.', ',')}</span>`;
                summaryContainer.appendChild(itemEl);
                subtotal += item.price * item.quantity;
            });

            // Preenche o campo hidden com os dados do carrinho para enviar ao PHP
            cartDataInput.value = JSON.stringify(cart);
            
            // Adiciona listener para recalcular o total quando a forma de pagamento mudar
            paymentOptions.forEach(option => option.addEventListener('change', calculateTotal));
            
            // Função para preencher o formulário de endereço
            const preencheFormulario = (endereco) => {
                document.getElementById('rua').value = endereco.logradouro;
                document.getElementById('bairro').value = endereco.bairro;
                document.getElementById('cidade').value = endereco.localidade;
                document.getElementById('estado').value = endereco.uf;
            }

            // Busca o CEP na API ViaCEP
            cepInput.addEventListener('blur', async () => {
                const cep = cepInput.value.replace(/\D/g, '');
                if (cep.length === 8) {
                    const url = `https://viacep.com.br/ws/${cep}/json/`;
                    try {
                        const response = await fetch(url);
                        const data = await response.json();
                        if (!data.erro) {
                            preencheFormulario(data);
                        }
                    } catch (error) {
                        console.error("Erro ao buscar CEP:", error);
                    }
                }
            });
            
            // Calcula o total inicial quando a página carrega
            calculateTotal();
        });
    </script>
</body>
</html>