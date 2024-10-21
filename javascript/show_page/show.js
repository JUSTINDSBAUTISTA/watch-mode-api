document.addEventListener('DOMContentLoaded', function () {
    const searchInputHeader = document.getElementById('searchInputHeader');
    const suggestions = document.getElementById('suggestions');
    const searchFormHeader = document.getElementById('searchFormHeader');

    if (searchInputHeader && searchFormHeader) {
        // Show suggestions when typing in the search input
        searchInputHeader.addEventListener('input', function () {
            const query = searchInputHeader.value.trim();
            if (query.length > 2) {
                fetch(`api.php?suggestion=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            suggestions.innerHTML = data.map(item => `
                                <div class="suggestion-item" data-id="${item.titleId}">
                                    <img src="${item.poster || 'default-small.jpg'}" alt="${item.name}">
                                    <span>${item.name} (ID: ${item.titleId})</span>
                                </div>
                            `).join('');
                            suggestions.classList.remove('d-none');
                        } else {
                            suggestions.classList.add('d-none');
                        }
                    });
            } else {
                suggestions.classList.add('d-none');
            }
        });

        // Hide suggestions when a suggestion item is clicked
        suggestions.addEventListener('click', function (event) {
            const target = event.target.closest('.suggestion-item');
            if (target) {
                const titleId = target.dataset.id;
                window.location.href = `show.php?titleId=${titleId}`;
            }
        });

        // Handle form submission to differentiate between title and ID search
        searchFormHeader.addEventListener('submit', function (event) {
            event.preventDefault();

            const query = searchInputHeader.value.trim();

            if (/^\d+$/.test(query)) {
                // If the query is all digits, assume it's an ID and redirect to show.php
                window.location.href = `show.php?titleId=${query}`;
            } else {
                // If it's a title, redirect to index.php with search parameter for title
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