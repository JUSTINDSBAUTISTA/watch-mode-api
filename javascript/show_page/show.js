
    // Hide the loading overlay once the page has fully loaded
    window.addEventListener('load', function () {
        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
        }
    });