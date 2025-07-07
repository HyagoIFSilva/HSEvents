document.addEventListener("DOMContentLoaded", function() {

    window.addEventListener("scroll", function () {
        const navbar = document.querySelector(".navbar");
      
        if (navbar) {
            navbar.classList.toggle("scrolled", window.scrollY > 50);
        }
    });

 
    const reveals = document.querySelectorAll(".reveal");

    function scrollReveal() {
        for (let i = 0; i < reveals.length; i++) {
            const windowHeight = window.innerHeight;
            const elementTop = reveals[i].getBoundingClientRect().top;
            const revealPoint = 150;

            if (elementTop < windowHeight - revealPoint) {
                reveals[i].classList.add("active");
            } 
            
        }
    }

    
    window.addEventListener("scroll", scrollReveal);
    scrollReveal();
});