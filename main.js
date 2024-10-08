document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const yearFilter = document.getElementById('yearFilter');
    const resultsContainer = document.getElementById('resultsContainer');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const paginationControls = document.getElementById('paginationControls');
    const resultsCountDiv = document.querySelector('.results');

    const itemsPerPage = 20;
    let currentPage = parseInt(localStorage.getItem('currentPage'), 10) || 1;

    // Load saved search data if available
    if (localStorage.getItem('searchResults')) {
        loadSavedSearch();
    } else if (searchInput.value) {
        fetchResults(currentPage); // Fetch initial results if there's a query
    }

    // Function to fetch and display results with pagination
    async function fetchResults(page = 1) {
        const keyword = searchInput.value.trim();
        const year = yearFilter.value;

        loadingSpinner.style.display = 'block';
        resultsContainer.innerHTML = '';
        resultsCountDiv.textContent = '';
        paginationControls.innerHTML = '';

        const response = await fetch(`api.php?title=${encodeURIComponent(keyword)}&year=${year}&page=${page}&itemsPerPage=${itemsPerPage}`);
        const { results, totalResults } = await response.json();

        loadingSpinner.style.display = 'none';
        displayResults(results);
        updatePagination(totalResults);

        // Save search state
        localStorage.setItem('searchKeyword', keyword);
        localStorage.setItem('searchYear', year);
        localStorage.setItem('currentPage', page);
        localStorage.setItem('searchResults', JSON.stringify(results));
        localStorage.setItem('totalResults', totalResults);
    }

    // Function to display results on the page
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

        // Attach event listeners to "View Details" buttons
        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                window.location.href = `show.php?watchmodeId=${id}`;
            });
        });
    }

    // Function to update pagination controls based on total results
    function updatePagination(totalResults) {
        const totalPages = Math.ceil(totalResults / itemsPerPage);
        paginationControls.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.className = 'btn btn-outline-primary mx-1';
            pageButton.textContent = i;
            if (i === currentPage) {
                pageButton.classList.add('active');
            }
            pageButton.addEventListener('click', function () {
                currentPage = i;
                fetchResults(currentPage);
            });
            paginationControls.appendChild(pageButton);
        }
    }

    // Load saved search data if it exists
    function loadSavedSearch() {
        const savedKeyword = localStorage.getItem('searchKeyword');
        const savedYear = localStorage.getItem('searchYear');
        const savedResults = JSON.parse(localStorage.getItem('searchResults'));
        const totalResults = parseInt(localStorage.getItem('totalResults'), 10) || 0;

        searchInput.value = savedKeyword || '';
        yearFilter.value = savedYear || '';

        displayResults(savedResults);
        updatePagination(totalResults);
    }

    // Event listener for the search form
    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();
        currentPage = 1;
        fetchResults(currentPage);
    });

    // Event listener to clear saved search data on hard refresh (CMD + SHIFT + R)
    document.addEventListener('keydown', function(event) {
        if ((event.ctrlKey || event.metaKey) && event.shiftKey && event.code === 'KeyR') {
            localStorage.clear();
        }
    });
});
