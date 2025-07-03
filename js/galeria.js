document.addEventListener('DOMContentLoaded', () => {

  // --- LÓGICA DO CARROSSEL (sem alterações) ---
  const track = document.querySelector('.carousel-track');
  if (track && track.children.length > 0) {
      const slides = Array.from(track.children);
      const nextButton = document.querySelector('.next');
      const prevButton = document.querySelector('.prev');
      const dotsNav = document.querySelector('.carousel-nav');

      // Adiciona um slide clone no final para o loop infinito
      track.appendChild(slides[0].cloneNode(true));
      
      const slideWidth = slides[0].getBoundingClientRect().width;

      slides.forEach((slide, index) => {
          const dot = document.createElement('button');
          dot.classList.add('carousel-indicator');
          if (index === 0) dot.classList.add('current-slide');
          dotsNav.appendChild(dot);
          slide.style.left = slideWidth * index + 'px';
      });

      const dots = Array.from(dotsNav.children);

      const updateDots = (currentIndex) => {
          dots.forEach(dot => dot.classList.remove('current-slide'));
          dots[currentIndex].classList.add('current-slide');
      };

      let currentIndex = 0;
      const moveToSlide = () => {
          track.style.transition = 'transform 0.7s cubic-bezier(0.68, -0.55, 0.27, 1.55)';
          track.style.transform = `translateX(-${slideWidth * currentIndex}px)`;

          if (currentIndex === slides.length) {
              setTimeout(() => {
                  track.style.transition = 'none';
                  track.style.transform = 'translateX(0)';
                  currentIndex = 0;
                  updateDots(currentIndex);
              }, 700);
          }
      };

      nextButton.addEventListener('click', () => {
          currentIndex = (currentIndex + 1) % (slides.length + 1);
          moveToSlide();
          if(currentIndex < slides.length) updateDots(currentIndex);
      });

      prevButton.addEventListener('click', () => {
          if (currentIndex === 0) return;
          currentIndex--;
          moveToSlide();
          updateDots(currentIndex);
      });
      
      dotsNav.addEventListener('click', e => {
          const targetDot = e.target.closest('button.carousel-indicator');
          if (!targetDot) return;
          currentIndex = dots.findIndex(dot => dot === targetDot);
          moveToSlide();
          updateDots(currentIndex);
      });
  }
});

// === FUNÇÕES DOS MODAIS CORRIGIDAS ===

// Abre o modal de confirmação de exclusão
function abrirModalExclusao(idDoEvento) {
  // Coloca o ID do evento no campo escondido do formulário
  document.getElementById('deleteIdCadEvento').value = idDoEvento;
  // Mostra o modal
  document.getElementById('deleteConfirmModal').style.display = 'flex';
}

// Fecha o modal de confirmação de exclusão
function fecharModalExclusao() {
  document.getElementById('deleteConfirmModal').style.display = 'none';
}