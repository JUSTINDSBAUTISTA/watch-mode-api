document.addEventListener('DOMContentLoaded', function () {
    const titleReleaseDatesPlaceholder = document.getElementById('titleReleaseDatesPlaceholder');
    const titleReleaseDatesContainer = document.getElementById('titleReleaseDatesContainer');

    // Function to load the title release dates when in view
    function loadTitleReleaseDates() {
        // Display the loading spinner
        titleReleaseDatesPlaceholder.style.display = 'block';

        // Simulate an API request or AJAX call to fetch the title release dates
        fetch('functions/fetch-title-release-dates.php') // Replace with the actual path to the file that returns the HTML for title release dates
            .then(response => response.text())
            .then(html => {
                // Insert the fetched HTML content into the container
                titleReleaseDatesContainer.innerHTML = html;

                // Hide the loading spinner after content is loaded
                titleReleaseDatesPlaceholder.style.display = 'none';
            })
            .catch(error => {
                console.error('Error loading title release dates:', error);
                titleReleaseDatesPlaceholder.innerHTML = '<p class="text-danger">Failed to load title release dates.</p>';
            });
    }

    // Use IntersectionObserver to load the title release dates when the user scrolls to the placeholder
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Load the title release dates when the placeholder is in view
                    loadTitleReleaseDates();
                    observer.unobserve(titleReleaseDatesPlaceholder); // Stop observing once loaded
                }
            });
        });

        // Start observing the placeholder
        observer.observe(titleReleaseDatesPlaceholder);
    } else {
        // Fallback for older browsers: Load immediately if IntersectionObserver is not supported
        loadTitleReleaseDates();
    }
});
