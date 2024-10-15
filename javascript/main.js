document.addEventListener('DOMContentLoaded', function () {
    const searchFormMain = document.getElementById('searchForm');
    const searchInputMain = document.getElementById('searchInputMain');
    const yearFilter = document.getElementById('yearFilter');
    const resultsContainer = document.getElementById('resultsContainer');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const paginationControls = document.getElementById('paginationControls');
    const resetButton = document.getElementById('resetButton');
    const sortButtons = document.getElementById('sortButtons');
    const sortTitleButton = document.getElementById('sortTitle');
    const sortYearButton = document.getElementById('sortYear');

    function resetSearch() {
        searchInputMain.value = '';
        yearFilter.value = '';
        resultsContainer.innerHTML = '';
        paginationControls.innerHTML = '';
        sortButtons.classList.add('d-none');
        localStorage.clear();

        // Reload the page without parameters
        window.location.href = '/watch-mode-api/';
    }

    resetButton.addEventListener('click', resetSearch);

    let results = [];
    const itemsPerPage = 20;
    let currentPage = 1;

    // Fetch results based on page number and search/year parameters
    async function fetchResults(page = 1) {
        const keyword = searchInputMain.value.trim();
        const year = yearFilter.value;

        // Show loading spinner
        if (loadingSpinner) loadingSpinner.style.display = 'block';
        
        resultsContainer.innerHTML = '';
        paginationControls.innerHTML = '';

        try {
            const response = await fetch(`api.php?title=${encodeURIComponent(keyword)}&year=${encodeURIComponent(year)}&page=${page}&itemsPerPage=${itemsPerPage}`);
            const { results: fetchedResults, totalResults } = await response.json();

            displayResults(fetchedResults);
            updatePagination(totalResults);
            sortButtons.classList.toggle('d-none', fetchedResults.length === 0);

            // Save search state to localStorage
            localStorage.setItem('searchKeyword', keyword);
            localStorage.setItem('searchYear', year);
            localStorage.setItem('currentPage', page);
            localStorage.setItem('searchResults', JSON.stringify(fetchedResults));
            localStorage.setItem('totalResults', totalResults);
        } catch (error) {
            console.error('Error fetching results:', error);
        } finally {
            if (loadingSpinner) loadingSpinner.style.display = 'none';
        }
    }

    // Update pagination controls
    function updatePagination(totalResults) {
        const totalPages = Math.ceil(totalResults / itemsPerPage);
        paginationControls.innerHTML = '';

        if (currentPage > 1) {
            const prevButton = document.createElement('button');
            prevButton.className = 'btn btn-outline-light mx-1';
            prevButton.textContent = 'Previous';
            prevButton.addEventListener('click', function () {
                currentPage--;
                fetchResults(currentPage);
            });
            paginationControls.appendChild(prevButton);
        }

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.className = 'btn btn-outline-light mx-1';
            pageButton.textContent = i;
            pageButton.addEventListener('click', function () {
                currentPage = i;
                fetchResults(currentPage);
            });
            paginationControls.appendChild(pageButton);
        }

        if (currentPage < totalPages) {
            const nextButton = document.createElement('button');
            nextButton.className = 'btn btn-outline-light mx-1';
            nextButton.textContent = 'Next';
            nextButton.addEventListener('click', function () {
                currentPage++;
                fetchResults(currentPage);
            });
            paginationControls.appendChild(nextButton);
        }
    }

    // Sorting functions
    function sortResults(criteria, order) {

        const savedResults = JSON.parse(localStorage.getItem('searchResults'));
        console.log(results);

        if(!savedResults) {
            return;
        }

        savedResults.sort((a, b) => {
            if (criteria === 'title') {
                return order === 'asc' ? a.title.localeCompare(b.title) : b.title.localeCompare(a.title);
            } else if (criteria === 'year') {
                return order === 'asc' ? a.year - b.year : b.year - a.year;
            }
        });
        displayResults(savedResults);
    }

    // Toggle sorting for Title and Year
    sortTitleButton.addEventListener('click', function () {
        console.log('Sorting by title...');
        const order = this.getAttribute('data-order');
        sortResults('title', order);
        this.setAttribute('data-order', order === 'asc' ? 'desc' : 'asc');
        this.textContent = order === 'asc' ? 'Sort by Title (Z-A)' : 'Sort by Title (A-Z)';
    });

    sortYearButton.addEventListener('click', function () {
        console.log('Sorting by year...');
        const order = this.getAttribute('data-order');
        sortResults('year', order);
        this.setAttribute('data-order', order === 'asc' ? 'desc' : 'asc');
        this.textContent = order === 'asc' ? 'Sort by Year (Oldest-Latest)' : 'Sort by Year (Latest-Oldest)';
    });
    
    // Form submission to reload the page with parameters
    searchFormMain.addEventListener('submit', function (event) {
        event.preventDefault();
        
        const keyword = searchInputMain.value.trim();
        const year = yearFilter.value;

        let url = '/watch-mode-api/?';
        if (keyword) url += `search=${encodeURIComponent(keyword)}`;
        if (year) url += `${keyword ? '&' : ''}year=${encodeURIComponent(year)}`;

        window.location.href = url;
    });

   // Display results
   function displayResults(fetchedResults) {
    resultsContainer.innerHTML = '';

    if (fetchedResults.length === 0) {
        // Display "No results" message if there are no matches
        resultsContainer.innerHTML = `
            <div class="col-12 text-center my-4 bg-warning bg-gradient p-5 rounded-pill">
                <h3 class="text-light">Sorry, try another title / id...</h3>
            </div>`;
        return;
    }

    fetchedResults.forEach(result => {
        const imageUrl = result.posterLarge || 'default.jpg';
        const card = document.createElement('div');
        card.className = 'col-lg-3 col-md-4 col-sm-6 mb-4';

        card.innerHTML = `
            <div class="card h-100 bg-dark">
                <img src="${imageUrl}" class="card-img-top position-relative" alt="${result.title}">
                <div class="icon-container">
                    <button class="btn btn-download" data-json="${encodeURIComponent(JSON.stringify(result))}">
                        <i class="fas fa-download" style="cursor: pointer;"></i>
                    </button>
                    ${
                        result.trailer
                            ? `<a href="${result.trailer}" target="_blank" class="btn btn-youtube"><i class="fab fa-youtube"></i></a>`
                            : ''
                    }
                </div>
                <div class="card-body d-flex flex-column">
                    <h4 class="card-id text-center mb-0 text-light">ID: ${result.id}</h4>
                    <hr class="hr my-1">
                    <h5 class="card-title mb-2 text-center text-warning">${result.title}</h5>
                    <p class="card-text mb-0 text-light"><strong>Year: </strong>${result.year || 'N/A'}</p>
                    <p class="card-text mb-0 text-light"><strong>Ratings: </strong>${result.user_rating || 'No ratings'}</p>
                    <p class="card-text mb-0 text-light"><strong>IMDB_ID: </strong>${result.imdb_id || 'N/A'}</p>
                    <p class="card-text mb-0 text-light"><strong>TMDB_ID: </strong>${result.tmdb_id || 'N/A'}</p>
                    <button data-id="${result.id}" class="btn btn-success mt-auto view-details">View Details</button>
                </div>
            </div>`;
        resultsContainer.appendChild(card);
    });

    document.querySelectorAll('.btn-download').forEach(button => {
        button.addEventListener('click', function () {
            downloadJson(this.getAttribute('data-json'));
        });
    });

    document.querySelectorAll('.view-details').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            window.location.href = `show.php?watchmodeId=${id}`;
        });
    });
}

    setTimeout(() => {
        const searchParams = new URLSearchParams(window.location.search);
        const searchQuery = searchParams.get('search');
        const yearQuery = searchParams.get('year');
        
        if ((searchQuery && searchQuery.trim() !== "") || (yearQuery && yearQuery.trim() !== "")) {
            if (searchQuery) searchInputMain.value = searchQuery;
            if (yearQuery) yearFilter.value = yearQuery;
            fetchResults();
        }
    }, 0);
    
});
