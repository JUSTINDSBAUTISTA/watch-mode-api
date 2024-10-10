document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const suggestions = document.getElementById('suggestions');
    const searchForm = document.getElementById('searchForm');
    
    // Show suggestions when typing in the search input
    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();
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
    searchForm.addEventListener('submit', function () {
        suggestions.classList.add('d-none');
    });
});

