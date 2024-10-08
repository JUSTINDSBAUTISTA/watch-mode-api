document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('suggestions');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();
        if (query.length > 2) {
            fetch(`https://api.watchmode.com/v1/autocomplete-search/?apiKey=<?php echo API_KEY; ?>&search_value=${encodeURIComponent(query)}&search_type=1`)
                .then(response => response.json())
                .then(data => {
                    if (data.results && data.results.length > 0) {
                        suggestionsBox.innerHTML = data.results.map(item => `
                            <div class="suggestion-item" data-id="${item.id}">
                                <img src="${item.image_url || 'default-small.jpg'}" alt="${item.name}">
                                <span>${item.name} (ID: ${item.id})</span>
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