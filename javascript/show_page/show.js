document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('suggestions');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();
        if (query.length > 2) {
            fetch(`api.php?suggestion=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        suggestionsBox.innerHTML = data.map(item => `
                            <div class="suggestion-item" data-id="${item.watchmodeId}">
                                <img src="${item.poster || 'default-small.jpg'}" alt="${item.title}">
                                <span>${item.title} (ID: ${item.watchmodeId})</span>
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
