document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const startYearFilter = document.getElementById('startYearFilter');
    const endYearFilter = document.getElementById('endYearFilter');
    const resultsContainer = document.getElementById('resultsContainer');
    const loadingSpinner = document.getElementById('loadingSpinner');

    // Check if previous search data exists in local storage
    if (localStorage.getItem('searchResults')) {
        const savedKeyword = localStorage.getItem('searchKeyword');
        const savedStartYear = localStorage.getItem('searchStartYear');
        const savedEndYear = localStorage.getItem('searchEndYear');
        const savedResults = JSON.parse(localStorage.getItem('searchResults'));

        // Populate input fields with saved values
        searchInput.value = savedKeyword || '';
        startYearFilter.value = savedStartYear || '';
        endYearFilter.value = savedEndYear || '';

        // Display saved search results
        displayResults(savedResults);
    }

    document.getElementById('searchForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        const keyword = searchInput.value.trim();
        const startYear = startYearFilter.value;
        const endYear = endYearFilter.value;

        // Show the loading spinner and clear previous results
        loadingSpinner.style.display = 'block';
        resultsContainer.innerHTML = '';

        // Fetch results from API
        const response = await fetch(`api.php?title=${encodeURIComponent(keyword)}&startYear=${startYear}&endYear=${endYear}`);
        const results = await response.json();

        // Hide the loading spinner and display results
        loadingSpinner.style.display = 'none';
        displayResults(results);

        // Save search data to local storage
        localStorage.setItem('searchKeyword', keyword);
        localStorage.setItem('searchStartYear', startYear);
        localStorage.setItem('searchEndYear', endYear);
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
