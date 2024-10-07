document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const yearFilter = document.getElementById('yearFilter');
    const resultsContainer = document.getElementById('resultsContainer');
    const loadingSpinner = document.getElementById('loadingSpinner');

    if (localStorage.getItem('searchResults')) {
        const savedKeyword = localStorage.getItem('searchKeyword');
        const savedYear = localStorage.getItem('searchYear');
        const savedResults = JSON.parse(localStorage.getItem('searchResults'));

        searchInput.value = savedKeyword || '';
        yearFilter.value = savedYear || '';

        displayResults(savedResults);
    }

    document.getElementById('searchForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        const keyword = searchInput.value.trim();
        const year = yearFilter.value;

        loadingSpinner.style.display = 'block';
        resultsContainer.innerHTML = '';

        const response = await fetch(`api.php?title=${encodeURIComponent(keyword)}&year=${year}`);
        const results = await response.json();

        loadingSpinner.style.display = 'none';
        displayResults(results);

        localStorage.setItem('searchKeyword', keyword);
        localStorage.setItem('searchYear', year);
        localStorage.setItem('searchResults', JSON.stringify(results));
    });

    function displayResults(results) {
        resultsContainer.innerHTML = '';
        results.forEach(result => {
            const imageUrl = result.poster || 'default.jpg';
            const card = document.createElement('div');
            card.className = 'col-lg-3 col-md-4 col-sm-6 mb-4';

            card.innerHTML = `
                <div class="card h-100">
                    <img src="${imageUrl}" class="card-img-top" alt="${result.title}">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-id">ID: ${result.id}</h4>
                        <hr class="hr">
                        <h5 class="card-title">${result.title}</h5>
                        <p class="card-text details"><strong>Ratings: </strong>${result.user_rating || 'No ratings.'}</p>
                        <p class="card-text details"><strong>IMDB_ID: </strong>${result.imdb_id}</p>
                        <p class="card-text details"><strong>TMDB_ID: </strong>${result.tmdb_id}</p>
                        <button data-id="${result.id}" class="btn btn-primary mt-auto view-details">View Details</button>
                    </div>
                </div>
            `;

            resultsContainer.appendChild(card);
        });

        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                window.location.href = `show.php?watchmodeId=${id}`;
            });
        });
    }
});
