document.addEventListener('DOMContentLoaded', function () {
    const searchInputHeader = document.getElementById('searchInputHeader');
    const searchFormHeader = document.getElementById('searchFormHeader');

    if (searchInputHeader && searchFormHeader) {
        // Handle form submission to differentiate between titleId, personId, and regular search
        searchFormHeader.addEventListener('submit', function (event) {
            event.preventDefault();

            const query = searchInputHeader.value.trim();

            // Check if query is numeric, assuming it's either a titleId or personId
            if (/^\d+$/.test(query)) {
                // Try to find the selected search type (title or person)
                const searchTypeElement = document.querySelector('input[name="searchType"]:checked');

                if (searchTypeElement) {
                    const searchType = searchTypeElement.value;
                    console.log("Search Type:", searchType);

                    if (searchType === 'person') {
                        // Redirect to person details page
                        window.location.href = `show.php?personId=${query}`;
                    } else {
                        // Redirect to title details page
                        window.location.href = `show.php?titleId=${query}`;
                    }
                } else {
                    console.error("No search type selected. Please select either 'title' or 'person'.");
                    alert("Please select whether you're searching for a title or a person.");
                }
            } else {
                // If it's a title or person name, redirect to index.php with search parameter
                let url = '/watchmode/?search=' + encodeURIComponent(query);
                console.log('This is the search URL: ' + url);
                window.location.href = url;
            }
        });
    } else {
        console.error("searchInputHeader or searchFormHeader not found in the DOM.");
    }

    // Function to handle JSON download
    function downloadJson(data = null) {
        let dataToUse = detailsData;

        if (data) {
            dataToUse = JSON.parse(decodeURIComponent(data));
        }   
        if (typeof dataToUse !== 'undefined') {
            const blob = new Blob([JSON.stringify(dataToUse, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const downloadLink = document.createElement('a');
            downloadLink.href = url;
            downloadLink.download = `${dataToUse.title || 'details'}_details.json`;
            downloadLink.click();
            URL.revokeObjectURL(url);
        } else {
            console.error("detailsData is not defined.");
        }
    }

    window.downloadJson = downloadJson;
});

// Hide the loading overlay once the page has fully loaded
window.addEventListener('load', function () {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'none';
    }
});
