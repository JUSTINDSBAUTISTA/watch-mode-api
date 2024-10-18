document.addEventListener('DOMContentLoaded', function () {
    const flagItems = document.querySelectorAll('.flag-item');

    function slideInOnScroll() {
        const windowHeight = window.innerHeight;
        
        flagItems.forEach(flag => {
            const flagTop = flag.getBoundingClientRect().top;
            
            if (flagTop < windowHeight * 0.9) {
                flag.classList.add('visible');
            }
        });
    }

    // Initial check in case items are already in view
    slideInOnScroll();

    // Event listener for scrolling
    window.addEventListener('scroll', slideInOnScroll);
});