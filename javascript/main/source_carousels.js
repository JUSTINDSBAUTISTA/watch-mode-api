document.addEventListener('DOMContentLoaded', function () {
    const sourceCarousels = document.querySelectorAll('.source-carousel-container');

    sourceCarousels.forEach(carousel => {
        const scrollContainer = carousel.querySelector('.source-scroll-container');

        // Calculate scroll speed based on item count
        const itemCount = scrollContainer.children.length;
        const scrollSpeed = itemCount <= 5 ? 50 : Math.max(30 - itemCount, 10);

        let scrollAmount = 0;

        function scrollItems() {
            scrollAmount += 1;
            if (scrollAmount >= scrollContainer.scrollWidth / 2) {
                scrollAmount = 0; // Reset to start to make it seamless
            }
            scrollContainer.scrollLeft = scrollAmount;
        }

        // Start the interval-based scrolling
        setInterval(scrollItems, scrollSpeed);
    });
});