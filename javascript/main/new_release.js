document.addEventListener('DOMContentLoaded', function () {
    const expandAllButton = document.getElementById('expandAll');
    const collapseAllButton = document.getElementById('collapseAll');
    const initialDisplayCount = 14; // The initial number of items shown

    if (expandAllButton && collapseAllButton) {
        expandAllButton.addEventListener('click', function () {
            const hiddenCards = document.querySelectorAll('.release-card.d-none');
            hiddenCards.forEach(card => {
                card.classList.remove('d-none');
            });

            // Switch the visibility of the buttons
            expandAllButton.classList.add('d-none');
            collapseAllButton.classList.remove('d-none');
        });

        collapseAllButton.addEventListener('click', function () {
            const allCards = document.querySelectorAll('.release-card');
            allCards.forEach((card, index) => {
                if (index >= initialDisplayCount) {
                    card.classList.add('d-none');
                }
            });

            // Switch the visibility of the buttons
            collapseAllButton.classList.add('d-none');
            expandAllButton.classList.remove('d-none');
        });
    }
});