document.addEventListener('DOMContentLoaded', () => {

    const swiper = new Swiper('.swiper', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    const cards = document.querySelectorAll('.gallery-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    cards.forEach(card => {
        observer.observe(card);
    });

});

function abrirModalExclusao(idDoEvento) {
    document.getElementById('deleteIdCadEvento').value = idDoEvento;
    document.getElementById('deleteConfirmModal').style.display = 'flex';
}

function fecharModalExclusao() {
    document.getElementById('deleteConfirmModal').style.display = 'none';
}