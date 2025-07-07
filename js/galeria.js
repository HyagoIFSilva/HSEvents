document.addEventListener('DOMContentLoaded', () => {
    // Tenta inicializar o Swiper (Carrossel)
    const swiperElement = document.querySelector('.swiper');
    if (swiperElement) {
        try {
            const swiper = new Swiper('.swiper', {
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
            });
        } catch (e) {
            console.error("Erro ao inicializar o Swiper.js:", e);
        }
    }

    // Lógica para o menu de opções (3 pontinhos)
    const optionsButtons = document.querySelectorAll('.options-btn');

    optionsButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault(); 
            event.stopPropagation(); 
            
            const currentDropdown = button.nextElementSibling;

            document.querySelectorAll('.options-dropdown.active').forEach(dropdown => {
                if (dropdown !== currentDropdown) {
                    dropdown.classList.remove('active');
                }
            });
            
            currentDropdown.classList.toggle('active');
        });
    });

    window.addEventListener('click', (event) => {
        if (!event.target.matches('.options-btn, .options-btn *')) {
            document.querySelectorAll('.options-dropdown.active').forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        }
    });

    // Lógica para o Modal de Exclusão (agora com verificação de segurança)
    const deleteModal = document.getElementById('deleteConfirmModal');
    
    // SÓ executa o código do modal SE o elemento existir na página
    if (deleteModal) {
        const deleteIdInput = document.getElementById('deleteIdCadEvento');
        const closeModalBtn = deleteModal.querySelector('.close-delete');
        const cancelModalBtn = deleteModal.querySelector('.btn-cancel');

        const abrirModalExclusao = (id) => {
            if (deleteIdInput) {
                deleteIdInput.value = id;
                deleteModal.style.display = 'flex';
                deleteModal.style.alignItems = 'center'; 
                deleteModal.style.justifyContent = 'center'; 
            }
        };

        const fecharModalExclusao = () => {
            deleteModal.style.display = 'none';
        };
        
        document.querySelectorAll('.delete-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const eventId = e.currentTarget.dataset.id;
                abrirModalExclusao(eventId);
            });
        });

        if (closeModalBtn) closeModalBtn.addEventListener('click', fecharModalExclusao);
        if (cancelModalBtn) cancelModalBtn.addEventListener('click', fecharModalExclusao);
    }
});