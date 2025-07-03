document.addEventListener("DOMContentLoaded", function() {

  // --- SEU CÓDIGO ORIGINAL ---
  window.addEventListener("scroll", function () {
      const navbar = document.querySelector(".navbar");
      navbar.classList.toggle("scrolled", window.scrollY > 50);
  });

  const reveals = document.querySelectorAll(".reveal");

  function scrollReveal() {
      for (let i = 0; i < reveals.length; i++) {
          const windowHeight = window.innerHeight;
          const elementTop = reveals[i].getBoundingClientRect().top;
          const revealPoint = 150;

          if (elementTop < windowHeight - revealPoint) {
              reveals[i].classList.add("active");
          } else {
              reveals[i].classList.remove("active");
          }
      }
  }

  window.addEventListener("scroll", scrollReveal);
  scrollReveal();
  // --- FIM DO SEU CÓDIGO ORIGINAL ---


  // --- NOVO CÓDIGO DO CARRINHO DE COMPRAS ---
  const comprarButtons = document.querySelectorAll('.comprar-btn');
  const cartIconButton = document.getElementById('cart-icon');
  const sidebarCart = document.getElementById('sidebar-cart');
  const closeCartButton = document.getElementById('close-cart');
  const cartItemsContainer = document.getElementById('cart-items');
  const cartCount = document.getElementById('cart-count');
  const subtotalPriceEl = document.getElementById('subtotal-price');
  const parcelaPriceEl = document.getElementById('parcela-price');
  const avistaPriceEl = document.getElementById('avista-price');
  const overlay = document.getElementById('overlay');
  const continuarComprando = document.getElementById('continuar-comprando');

  let cart = []; // Array para armazenar os itens do carrinho

  // Função para abrir o carrinho lateral
  function openCart() {
      sidebarCart.classList.add('open');
      overlay.classList.add('show');
  }

  // Função para fechar o carrinho lateral
  function closeCart() {
      sidebarCart.classList.remove('open');
      overlay.classList.remove('show');
  }

  // Adiciona evento de clique aos botões "COMPRAR +"
  comprarButtons.forEach(button => {
      button.addEventListener('click', () => {
          const card = button.closest('.produto-card');
          const product = {
              id: card.dataset.id,
              name: card.dataset.nome,
              price: parseFloat(card.dataset.preco),
              img: card.dataset.img,
              description: card.querySelector('p').textContent,
              quantity: 1
          };
          addToCart(product);
      });
  });

  // Função para adicionar um item ao carrinho
  function addToCart(product) {
      const existingProductIndex = cart.findIndex(item => item.id === product.id);

      if (existingProductIndex > -1) {
          // Se o produto já existe, apenas incrementa a quantidade
          cart[existingProductIndex].quantity += 1;
      } else {
          // Se for um novo produto, adiciona ao array
          cart.push(product);
      }

      cartIconButton.style.display = 'block'; // Garante que o ícone do carrinho esteja visível
      updateCart();
      openCart(); // Abre o carrinho automaticamente ao adicionar um novo item
  }
  
  // Função para atualizar a exibição do carrinho (itens, contagem e totais)
  function updateCart() {
      cartItemsContainer.innerHTML = ''; // Limpa a lista de itens para recriá-la
      let subtotal = 0;

      cart.forEach(item => {
          subtotal += item.price * item.quantity;
          const cartItemEl = document.createElement('div');
          cartItemEl.classList.add('cart-item');
          cartItemEl.innerHTML = `
              <img src="${item.img}" alt="${item.name}">
              <div class="cart-item-info">
                  <h4>${item.name}</h4>
                  <p>${item.description}</p>
                  <div class="cart-item-price">R$ ${item.price.toFixed(2).replace('.', ',')}</div>
              </div>
              <button class="remove-item" data-id="${item.id}">&times;</button>
          `;
          cartItemsContainer.appendChild(cartItemEl);
      });

      // Calcula e atualiza os totais
      const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
      const descontoAvista = subtotal * 0.90; // Exemplo de 10% de desconto
      const valorParcela = subtotal > 0 ? subtotal / 12 : 0;

      cartCount.textContent = totalItems;
      subtotalPriceEl.textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
      avistaPriceEl.textContent = `R$ ${descontoAvista.toFixed(2).replace('.', ',')}`;
      parcelaPriceEl.textContent = `R$ ${valorParcela.toFixed(2).replace('.', ',')}`;

 
      addRemoveEventListeners();
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
      
      if (cart.length === 0) {
          cartIconButton.style.display = 'none';
          closeCart();
      }
  }

  // Event Listeners para abrir e fechar o carrinho
  cartIconButton.addEventListener('click', (e) => {
      e.preventDefault();
      openCart();
  });
  
  closeCartButton.addEventListener('click', closeCart);
  overlay.addEventListener('click', closeCart); // Fecha o carrinho se clicar fora (no overlay)
  
  continuarComprando.addEventListener('click', (e) => {
      e.preventDefault();
      closeCart();
  });
  // --- FIM DO NOVO CÓDIGO ---
});