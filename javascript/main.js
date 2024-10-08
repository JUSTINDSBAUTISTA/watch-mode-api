document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const yearFilter = document.getElementById('yearFilter');
    const resultsContainer = document.getElementById('resultsContainer');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const paginationControls = document.getElementById('paginationControls');

    const itemsPerPage = 20;
    let currentPage = 1;

    // Function to fetch results by title
    async function fetchResults(page = 1) {
        const keyword = searchInput.value.trim();
        const year = yearFilter.value;

        loadingSpinner.style.display = 'block';
        resultsContainer.innerHTML = '';
        paginationControls.innerHTML = '';

        const response = await fetch(`api.php?title=${encodeURIComponent(keyword)}&year=${year}&page=${page}&itemsPerPage=${itemsPerPage}`);
        const { results, totalResults } = await response.json();

        loadingSpinner.style.display = 'none';
        displayResults(results);
        updatePagination(totalResults);
    }

    // Display search results
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
                        <p class="card-text mb-0 text-light"><strong>Ratings: </strong>${result.user_rating || 'No ratings'}</p>
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

    // Submit handler for the search form
    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const query = searchInput.value.trim();

        if (/^\d+$/.test(query)) {
            // If input is a Watchmode ID, redirect to show.php
            window.location.href = `show.php?watchmodeId=${query}`;
        } else {
            // Otherwise, perform title-based search
            currentPage = 1;
            fetchResults(currentPage);
        }
    });
});
