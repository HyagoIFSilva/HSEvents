document.addEventListener("DOMContentLoaded", function() {

    // --- LÓGICA 1: NAVBAR SCROLL ---
    try {
        window.addEventListener("scroll", function () {
            const navbar = document.querySelector(".navbar");
            if (navbar) {
                navbar.classList.toggle("scrolled", window.scrollY > 50);
            }
        });
    } catch (e) { console.error("Erro na lógica da Navbar:", e); }

    // --- LÓGICA 2: ANIMAÇÃO AO ROLAR (REVEAL) ---
    try {
        const animatedElements = document.querySelectorAll('.animate-on-scroll');
        if (animatedElements.length > 0) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            animatedElements.forEach(el => { observer.observe(el); });
        }
    } catch (e) { console.error("Erro na lógica de animação de scroll:", e); }

    // --- LÓGICA 3: CARROSSEL DE EVENTOS EM DESTAQUE ---
    try {
        const featuredSwiperEl = document.querySelector('.featured-swiper');
        if (featuredSwiperEl) {
            new Swiper(featuredSwiperEl, {
                loop: true, slidesPerView: 1, spaceBetween: 30, centeredSlides: true, grabCursor: true,
                navigation: { nextEl: '.featured-swiper-container .swiper-button-next', prevEl: '.featured-swiper-container .swiper-button-prev' },
                breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
            });
        }
    } catch (e) { console.error("Erro no carrossel de eventos:", e); }

    // --- LÓGICA 4: CARROSSEL DE PRODUTOS ---
    try {
        const produtosSwiperEl = document.querySelector('.produtos-swiper');
        if (produtosSwiperEl) {
            new Swiper(produtosSwiperEl, {
                loop: true, slidesPerView: 1, spaceBetween: 30,
                navigation: { nextEl: '.produtos-swiper-container .swiper-button-next', prevEl: '.produtos-swiper-container .swiper-button-prev' },
                breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
            });
        }
    } catch (e) { console.error("Erro no carrossel de produtos:", e); }

    // --- LÓGICA 5: WIDGET DE FEEDBACK E MODAL ---
    try {
        const feedbackTrigger = document.getElementById('feedback-trigger');
        const feedbackWidget = document.getElementById('feedback-widget');
        const contatoModal = document.getElementById('contato-modal');
        
        if (feedbackTrigger && feedbackWidget) {
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    setTimeout(() => { feedbackWidget.classList.add('visible'); }, 10);
                } else {
                    feedbackWidget.classList.remove('visible');
                }
            }, { threshold: 0.1 });
            observer.observe(feedbackTrigger);
        }

        if (contatoModal && feedbackWidget) {
            const closeBtn = contatoModal.querySelector('.close-modal-btn');
            feedbackWidget.addEventListener('click', () => { contatoModal.classList.add('visible'); });
            if (closeBtn) { closeBtn.addEventListener('click', () => { contatoModal.classList.remove('visible'); }); }
            contatoModal.addEventListener('click', (e) => { if (e.target === contatoModal) { contatoModal.classList.remove('visible'); } });
        }
    } catch(e) { console.error("Erro no widget de feedback:", e); }
});