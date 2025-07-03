document.addEventListener('DOMContentLoaded', () => {
  const comprarButtons = document.querySelectorAll('.comprar-btn');
  const cartIconButton = document.getElementById('cart-icon');
  const sidebarCart = document.getElementById('sidebar-cart');
  const closeCartButton = document.getElementById('close-cart');
  const cartItemsContainer = document.getElementById('cart-items');
  const cartCount = document.getElementById('cart-count');
  const subtotalPriceEl = document.getElementById('subtotal-price');
  const overlay = document.getElementById('overlay');
  const continuarComprando = document.getElementById('continuar-comprando');


  let cart = JSON.parse(localStorage.getItem('shoppingCart')) || [];

  function saveCart() {
      localStorage.setItem('shoppingCart', JSON.stringify(cart));
  }

  function openCart() {
      sidebarCart.classList.add('open');
      overlay.classList.add('show');
  }

  function closeCart() {
      sidebarCart.classList.remove('open');
      overlay.classList.remove('show');
  }

  comprarButtons.forEach(button => {
      button.addEventListener('click', (e) => {
          e.stopPropagation();
          const card = button.closest('.comprar-btn'); 
          const product = {
              id: card.dataset.id,
              name: card.dataset.nome,
              price: parseFloat(card.dataset.preco),
              img: card.dataset.img,
              quantity: 1
          };
          addToCart(product);
      });
  });

  function addToCart(product) {
      const existingProductIndex = cart.findIndex(item => item.id === product.id);
      if (existingProductIndex > -1) {
          cart[existingProductIndex].quantity += 1;
      } else {
          cart.push(product);
      }
      updateCart();
      openCart();
  }

  function updateCart() {
      cartItemsContainer.innerHTML = '';
      let subtotal = 0;
      let totalItems = 0;

      if (cart.length === 0) {
          cartItemsContainer.innerHTML = '<p style="text-align:center; color:#888;">Seu carrinho está vazio.</p>';
      } else {
          cart.forEach(item => {
              subtotal += item.price * item.quantity;
              totalItems += item.quantity;

              const cartItemEl = document.createElement('div');
              cartItemEl.classList.add('cart-item');
              cartItemEl.innerHTML = `
                  <img src="${item.img}" alt="${item.name}">
                  <div class="cart-item-info">
                      <h4>${item.name}</h4>
                      <div class="cart-item-price">R$ ${item.price.toFixed(2).replace('.', ',')} (x${item.quantity})</div>
                  </div>
                  <button class="remove-item" data-id="${item.id}" title="Remover item">&times;</button>
              `;
              cartItemsContainer.appendChild(cartItemEl);
          });
      }

      cartCount.textContent = totalItems;
      cartIconButton.style.display = totalItems > 0 ? 'flex' : 'none';
      subtotalPriceEl.textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
      
      addRemoveEventListeners();
      saveCart(); 
  }

  function addRemoveEventListeners() {
      const removeButtons = document.querySelectorAll('.remove-item');
      removeButtons.forEach(button => {
          button.addEventListener('click', (e) => {
              const id = e.target.dataset.id;
              removeFromCart(id);
          });
      });
  }

  function removeFromCart(productId) {
      cart = cart.filter(item => item.id !== productId);
      updateCart();
  }
  

  if (cartIconButton) cartIconButton.addEventListener('click', openCart);
  if (closeCartButton) closeCartButton.addEventListener('click', closeCart);
  if (overlay) overlay.addEventListener('click', closeCart);
  if (continuarComprando) continuarComprando.addEventListener('click', (e) => {
      e.preventDefault();
      closeCart();
  });


  updateCart();
});