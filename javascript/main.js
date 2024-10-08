document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const yearFilter = document.getElementById('yearFilter');
    const resultsContainer = document.getElementById('resultsContainer');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const paginationControls = document.getElementById('paginationControls');
    const resultsCountDiv = document.querySelector('.results');
    const suggestionsBox = document.getElementById('suggestions');

    const itemsPerPage = 20;
    let currentPage = parseInt(localStorage.getItem('currentPage'), 10) || 1;

    // Load saved search data if available
    if (localStorage.getItem('searchResults')) {
        loadSavedSearch();
    } else if (searchInput.value) {
        fetchResults(currentPage); // Fetch initial results if there's a query
    }

    // Fetch results with pagination
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

    // Display results
    function displayResults(results) {
        resultsContainer.innerHTML = '';

        results.forEach(result => {
            if (!result || result.success === false) return;

            const imageUrl = result.poster || 'default.jpg';
            const card = document.createElement('div');
            card.className = 'col-lg-3 col-md-4 col-sm-6 mb-4';

            card.innerHTML = `
                <div class="card h-100 bg-dark">
                    <img src="${imageUrl}" class="card-img-top" alt="${result.title}">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-id text-center mb-0 text-light">ID: ${result.id}</h4>
                        <hr class="hr my-1">
                        <h5 class="card-title mb-2 text-center text-warning">${result.title}</h5>
                        <p class="card-text mb-0 text-light"><strong>Ratings: </strong>${result.user_rating || 'No ratings.'}</p>
                        <p class="card-text mb-0 text-light"><strong>IMDB_ID: </strong>${result.imdb_id}</p>
                        <p class="card-text mb-0 text-light"><strong>TMDB_ID: </strong>${result.tmdb_id}</p>
                        <button data-id="${result.id}" class="btn btn-success mt-auto view-details">View Details</button>
                    </div>
                </div>
            `;
            resultsContainer.appendChild(card);
        });

        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                window.location.href = `show.php?watchmodeId=${id}`;
            });
        });
    }

    // Update pagination controls
    function updatePagination(totalResults) {
        const totalPages = Math.ceil(totalResults / itemsPerPage);
        paginationControls.innerHTML = '';

        if (currentPage > 1) {
            const prevButton = document.createElement('button');
            prevButton.className = 'btn btn-outline-primary mx-1';
            prevButton.textContent = 'Previous';
            prevButton.addEventListener('click', function () {
                currentPage--;
                fetchResults(currentPage);
            });
            paginationControls.appendChild(prevButton);
        }

        const maxPageButtons = 5;
        const halfMaxButtons = Math.floor(maxPageButtons / 2);
        let startPage = Math.max(1, currentPage - halfMaxButtons);
        let endPage = Math.min(totalPages, currentPage + halfMaxButtons);

        if (currentPage <= halfMaxButtons) {
            endPage = Math.min(totalPages, maxPageButtons);
        } else if (currentPage + halfMaxButtons >= totalPages) {
            startPage = Math.max(1, totalPages - maxPageButtons + 1);
        }

        for (let i = startPage; i <= endPage; i++) {
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

        if (currentPage < totalPages) {
            const nextButton = document.createElement('button');
            nextButton.className = 'btn btn-outline-primary mx-1';
            nextButton.textContent = 'Next';
            nextButton.addEventListener('click', function () {
                currentPage++;
                fetchResults(currentPage);
            });
            paginationControls.appendChild(nextButton);
        }
    }

    // Load saved search data
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

    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();
        currentPage = 1;
        fetchResults(currentPage);
    });

    // Event listener for search suggestions
    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();
        if (query.length > 2) {
            fetch(`api.php?suggestion=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (suggestionsBox && data && data.length > 0) {
                        suggestionsBox.innerHTML = data.map(item => `
                            <div class="suggestion-item" data-id="${item.watchmodeId}">
                                <img src="${item.poster || 'default-small.jpg'}" alt="${item.title}">
                                <span>${item.title} (ID: ${item.watchmodeId})</span>
                            </div>
                        `).join('');
                        suggestionsBox.classList.remove('d-none');
                    } else if (suggestionsBox) {
                        suggestionsBox.classList.add('d-none');
                    }
                });
        } else if (suggestionsBox) {
            suggestionsBox.classList.add('d-none');
        }
    });

    // Navigate to show.php for selected suggestion
    suggestionsBox.addEventListener('click', function (event) {
        const target = event.target.closest('.suggestion-item');
        if (target) {
            const watchmodeId = target.dataset.id; // Retrieve the ID from data attribute
            if (watchmodeId) {
                window.location.href = `show.php?watchmodeId=${watchmodeId}`; // Navigate with valid ID
            }
        }
    });

    document.addEventListener('keydown', function(event) {
        if ((event.ctrlKey || event.metaKey) && event.shiftKey && event.code === 'KeyR') {
            localStorage.clear();
        }
    });
});
