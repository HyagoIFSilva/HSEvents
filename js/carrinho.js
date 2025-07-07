document.addEventListener('DOMContentLoaded', () => {
    const cartIconButton = document.getElementById('cart-icon');
    const sidebarCart = document.getElementById('sidebar-cart');
    const overlay = document.getElementById('overlay');
    const toastNotification = document.getElementById('toast-notification');

    let cart = JSON.parse(localStorage.getItem('shoppingCart')) || [];

    function saveCart() {
        localStorage.setItem('shoppingCart', JSON.stringify(cart));
    }

    function showToast(message) {
        if (!toastNotification) return;
        toastNotification.textContent = message;
        toastNotification.classList.add('show');
        setTimeout(() => {
            toastNotification.classList.remove('show');
        }, 3000);
    }

    function openCart() {
        if (!sidebarCart || !overlay) return;
        sidebarCart.classList.add('open');
        overlay.classList.add('show');
        renderCart();
    }

    function closeCart() {
        if (!sidebarCart || !overlay) return;
        sidebarCart.classList.remove('open');
        overlay.classList.remove('show');
    }

    function addToCart(product) {
        const existingProductIndex = cart.findIndex(item => item.id === product.id);
        if (existingProductIndex > -1) {
            cart[existingProductIndex].quantity += 1;
        } else {
            cart.push(product);
        }
        showToast(`✅ "${product.name}" foi adicionado ao carrinho!`);
        updateCartIcon();
        saveCart();
        openCart();
    }

    function updateCartIcon() {
        if (!cartIconButton) return;
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            cartCount.textContent = totalItems;
            cartIconButton.style.display = totalItems > 0 ? 'flex' : 'none';
        }
    }

    function renderCart() {
        if (!sidebarCart) return;
        
        sidebarCart.innerHTML = '';

        const cartHeader = document.createElement('div');
        cartHeader.classList.add('cart-header');
        cartHeader.innerHTML = `<h3>Resumo do carrinho</h3><button class="close-cart">&times;</button>`;
        sidebarCart.appendChild(cartHeader);
        
        const cartItemsContainer = document.createElement('div');
        cartItemsContainer.classList.add('cart-items');
        
        let subtotal = 0;
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p style="text-align:center; padding: 20px;">Seu carrinho está vazio.</p>';
        } else {
            cart.forEach(item => {
                subtotal += item.price * item.quantity;
                const cartItemEl = document.createElement('div');
                cartItemEl.classList.add('cart-item');
                cartItemEl.innerHTML = `<img src="${item.img}" alt="${item.name}"><div class="cart-item-info"><h4>${item.name}</h4><div class="cart-item-price">R$ ${item.price.toFixed(2).replace('.', ',')} (x${item.quantity})</div></div><button class="remove-item" data-id="${item.id}" title="Remover item">&times;</button>`;
                cartItemsContainer.appendChild(cartItemEl);
            });
        }
        sidebarCart.appendChild(cartItemsContainer);
        
        const cartFooter = document.createElement('div');
        cartFooter.classList.add('cart-footer');
        cartFooter.innerHTML = `<div class="subtotal"><span>Subtotal</span><span>R$ ${subtotal.toFixed(2).replace('.', ',')}</span></div><button class="finalizar-pedido">FECHAR PEDIDO</button><a href="#" class="continuar-comprando">Continuar comprando</a>`;
        sidebarCart.appendChild(cartFooter);

        addCartEventListeners();
    }

    function removeFromCart(productId) {
        cart = cart.filter(item => item.id !== productId);
        saveCart();
        updateCartIcon();
        renderCart();
    }
    
    function addCartEventListeners() {
        sidebarCart.querySelector('.close-cart')?.addEventListener('click', closeCart);
        sidebarCart.querySelector('.continuar-comprando')?.addEventListener('click', (e) => {
            e.preventDefault();
            closeCart();
        });

        sidebarCart.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', (e) => {
                removeFromCart(e.currentTarget.dataset.id);
            });
        });

        const finalizarPedidoBtn = sidebarCart.querySelector('.finalizar-pedido');
        finalizarPedidoBtn?.addEventListener('click', () => {
            if (cart.length > 0) {
                window.location.href = 'checkout.php';
            } else {
                alert('Seu carrinho está vazio!');
            }
        });
    }

    function initializeBuyButtons() {
        const comprarButtons = document.querySelectorAll('.comprar-btn');
        comprarButtons.forEach(button => {
            button.addEventListener('click', () => {
                const product = {
                    id: button.dataset.id,
                    name: button.dataset.nome,
                    price: parseFloat(button.dataset.preco),
                    img: button.dataset.img,
                    quantity: 1
                };
                addToCart(product);
            });
        });
    }

    if (cartIconButton) {
        cartIconButton.addEventListener('click', (e) => {
            e.preventDefault();
            openCart();
        });
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeCart);
    }
    
    initializeBuyButtons();
    updateCartIcon();
});