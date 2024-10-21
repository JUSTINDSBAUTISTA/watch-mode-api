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
                // Redirect based on selection for title or person
                const searchType = document.querySelector('input[name="searchType"]:checked').value; // Assuming you have radio buttons for title/person
                if (searchType === 'person') {
                    window.location.href = `show.php?personId=${query}`;
                } else {
                    window.location.href = `show.php?titleId=${query}`;
                }
            } else {
                // If it's a title or person name, redirect to index.php with search parameter
                let url = '/watchmode/?search=' + encodeURIComponent(query);
                console.log('this is the response' + url);
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
