document.addEventListener("DOMContentLoaded", function() {
    // Lógica para o Navbar (continua a mesma)
    window.addEventListener("scroll", function () {
        const navbar = document.querySelector(".navbar");
        if (navbar) {
            navbar.classList.toggle("scrolled", window.scrollY > 50);
        }
    });
  
    // --- NOVO SISTEMA DE ANIMAÇÃO AO ROLAR A PÁGINA ---
    const animatedElements = document.querySelectorAll('.animate-on-scroll');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            // Quando o elemento entra na tela
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                // Opcional: para a animação não repetir ao rolar para cima e para baixo
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1 // A animação começa quando 10% do elemento está visível
    });

    animatedElements.forEach(el => {
        observer.observe(el);
    });


    // --- LÓGICA DOS CARROSSÉIS (continua a mesma) ---
    const featuredSwiperEl = document.querySelector('.featured-swiper');
    if(featuredSwiperEl) {
        new Swiper(featuredSwiperEl, {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            centeredSlides: true,
            grabCursor: true,
            navigation: {
              nextEl: '.featured-swiper-container .swiper-button-next',
              prevEl: '.featured-swiper-container .swiper-button-prev',
            },
            breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
        });
    }

    const produtosSwiperEl = document.querySelector('.produtos-swiper');
    if (produtosSwiperEl) {
        new Swiper(produtosSwiperEl, {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: {
                nextEl: '.produtos-swiper-container .swiper-button-next',
                prevEl: '.produtos-swiper-container .swiper-button-prev',
            },
            breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
        });
    }
});