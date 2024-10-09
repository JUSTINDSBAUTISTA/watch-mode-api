document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('suggestions');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();
        if (query.length > 2) {
            fetch(`api.php?suggestion=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data && data.length > 0) {
                        suggestionsBox.innerHTML = data.map(item => `
                            <div class="suggestion-item" data-id="${item.watchmodeId}">
                                <img src="${item.poster || 'default-small.jpg'}" alt="${item.name}">
                                <span>${item.name} (ID: ${item.watchmodeId})</span>
                            </div>
                        `).join('');
                        suggestionsBox.classList.remove('d-none');
                    } else {
                        suggestionsBox.classList.add('d-none');
                    }
                });
        } else {
            suggestionsBox.classList.add('d-none');
        }
    });

    suggestionsBox.addEventListener('click', function (event) {
        const target = event.target.closest('.suggestion-item');
        if (target) {
            const watchmodeId = target.dataset.id;
            window.location.href = `show.php?watchmodeId=${watchmodeId}`;
        }
    });
});

function downloadJson() {
    // Ensure detailsData is defined before downloading
    if (typeof detailsData !== 'undefined') {
        // Convert the JSON object to a string and create a Blob
        const blob = new Blob([JSON.stringify(detailsData, null, 2)], { type: 'application/json' });

        // Create a URL for the Blob and trigger download
        const url = URL.createObjectURL(blob);
        const downloadLink = document.createElement('a');
        downloadLink.href = url;
        downloadLink.download = `${detailsData.title || 'details'}_details.json`;
        downloadLink.click();

        // Clean up
        URL.revokeObjectURL(url);
    } else {
        console.error("detailsData is not defined.");
    }
}

