const searchInputHeader = document.getElementById('searchInputHeader');
const suggestions = document.getElementById('suggestions');
const searchFormHeader = document.getElementById('searchForm');
document.addEventListener('DOMContentLoaded', function () {
    // Show suggestions when typing in the search input
    searchInputHeader.addEventListener('input', function () {
        const query = searchInputHeader.value.trim();
        if (query.length > 2) {
            fetch(`api.php?suggestion=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        suggestions.innerHTML = data.map(item => `
                            <div class="suggestion-item" data-id="${item.watchmodeId}">
                                <img src="${item.poster || 'default-small.jpg'}" alt="${item.name}">
                                <span>${item.name} (ID: ${item.watchmodeId})</span>
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
            const watchmodeId = target.dataset.id;
            window.location.href = `show.php?watchmodeId=${watchmodeId}`;
        }
    });

    // Hide suggestions when form is submitted
    searchFormHeader.addEventListener('submit', function (event) {
        event.preventDefault();
        let url = '/watch-mode-api?search=' + encodeURIComponent(searchInputHeader.value);

        //  suggestions.classList.add('d-none');
        window.location.href = url;
        
    });


    function downloadJson(data = null) {
        let dataToUse = detailsData;

        if (data) {
            dataToUse = JSON.parse(decodeURIComponent(data));
        }   
        if (typeof dataToUse !== 'undefined') {
            // Convert the JSON object to a string and create a Blob
            const blob = new Blob([JSON.stringify(dataToUse, null, 2)], { type: 'application/json' });

            // Create a URL for the Blob and trigger download
            const url = URL.createObjectURL(blob);
            const downloadLink = document.createElement('a');
            downloadLink.href = url;
            downloadLink.download = `${dataToUse.title || 'details'}_details.json`;
            downloadLink.click();

            // Clean up
            URL.revokeObjectURL(url);
        } else {
            console.error("detailsData is not defined.");
        }
    }

    window.downloadJson = downloadJson;

});