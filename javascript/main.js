document.addEventListener('DOMContentLoaded', function () {
    const searchFormMain = document.getElementById('searchFormMain');
    if (searchFormMain) {
        const searchInputMain = document.getElementById('searchInputMain');
        const searchType = document.getElementById('searchType');
        const yearFilter = document.getElementById('yearFilter');
        const resultsContainer = document.getElementById('resultsContainer');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const paginationControls = document.getElementById('paginationControls');
        const resetButton = document.getElementById('resetButton');
        const sortButtons = document.getElementById('sortButtons');
        const sortNameButton = document.getElementById('sortName');
        const sortYearButton = document.getElementById('sortYear');
        const sourcesSection = document.getElementById('sourcesSection');
        const flagSection = document.querySelector('#flagsSection');

        function resetSearch() {
            searchInputMain.value = '';
            searchType.value = '';
            yearFilter.value = '';
            resultsContainer.innerHTML = '';
            paginationControls.innerHTML = '';
            sortButtons.classList.add('d-none');
            sourcesSection.style.display = 'none';
            localStorage.clear();

            // Reload the page without parameters
            window.location.href = '/watchmode/';
        }

        resetButton.addEventListener('click', resetSearch);

        let results = [];
        const itemsPerPage = 20;
        let currentPage = 1;

        // Fetch results from the API
        async function fetchResults(page = 1) {
            const keyword = searchInputMain.value.trim();
            const searchTypeValue = searchType.value;
            const year = yearFilter.value;
        
            // Show loading spinner
            if (loadingSpinner) loadingSpinner.style.display = 'block';
            if (sourcesSection) sourcesSection.style.display = 'none';
            if (flagSection) flagSection.style.display = 'none';
        
            resultsContainer.innerHTML = '';
            paginationControls.innerHTML = '';
        
            try {
                const response = await fetch(`api.php?title=${encodeURIComponent(keyword)}&searchType=${encodeURIComponent(searchTypeValue)}&year=${encodeURIComponent(year)}&page=${page}&itemsPerPage=${itemsPerPage}`);
                
                // Log the full response to debug
                const responseData = await response.json();

                // Check if the response contains 'results'
                const fetchedResults = responseData.results || []; // Default to an empty array if 'results' is undefined
                const totalResults = responseData.totalResults || 0;
        
                // Display results and update pagination
                displayResults(fetchedResults);
                updatePagination(totalResults);
                sortButtons.classList.toggle('d-none', fetchedResults.length === 0);
        
                // Save search state to localStorage
                localStorage.setItem('searchKeyword', keyword);
                localStorage.setItem('searchType', searchTypeValue);
                localStorage.setItem('searchYear', year);
                localStorage.setItem('currentPage', page);
                localStorage.setItem('searchResults', JSON.stringify(fetchedResults));
                localStorage.setItem('totalResults', totalResults);
            } catch (error) {
                console.error('Error fetching results:', error);
            } finally {
                if (loadingSpinner) loadingSpinner.style.display = 'none';
                if (flagSection) flagSection.style.display = 'none';
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
            if(!savedResults) {
                return;
            }

            savedResults.sort((a, b) => {
                if (criteria === 'name') {
                    return order === 'asc' ? a.name.localeCompare(b.name) : b.name.localeCompare(a.name);
                } else if (criteria === 'year') {
                    return order === 'asc' ? a.year - b.year : b.year - a.year;
                }
            });
            displayResults(savedResults);
        }

        // Toggle sorting for Name and Year
        sortNameButton.addEventListener('click', function () {
            const order = this.getAttribute('data-order');
            sortResults('name', order);
            this.setAttribute('data-order', order === 'asc' ? 'desc' : 'asc');
            this.textContent = order === 'asc' ? 'Sort by Name (Z-A)' : 'Sort by Name (A-Z)';
        });

        sortYearButton.addEventListener('click', function () {
            const order = this.getAttribute('data-order');
            sortResults('year', order);
            this.setAttribute('data-order', order === 'asc' ? 'desc' : 'asc');
            this.textContent = order === 'asc' ? 'Sort by Year (Oldest-Latest)' : 'Sort by Year (Latest-Oldest)';
        });
                
        // Form submission to reload the page with parameters or redirect if ID
        searchFormMain.addEventListener('submit', function (event) {
            event.preventDefault();
            const keyword = searchInputMain.value.trim();
            const searchTypeValue = searchType.value;  // Capture the searchType value correctly
            const year = yearFilter.value;

            if (/^\d+$/.test(keyword)) {
                // If the keyword is numeric, assume it's an ID (either title or person) and redirect accordingly
                if (searchTypeValue === 'person') {
                    // Redirect to person details page if search type is person
                    window.location.href = `show.php?personId=${keyword}`;
                } else {
                    // Redirect to title details page if search type is title
                    window.location.href = `show.php?titleId=${keyword}`;
                }
            } else {
                // Otherwise, build the URL with title, year, and searchType parameters for a text-based search
                let url = '?';
                if (keyword) url += `search=${encodeURIComponent(keyword)}`;
                if (year) url += `${keyword ? '&' : ''}year=${encodeURIComponent(year)}`;
                if (searchTypeValue) url += `${keyword || year ? '&' : ''}searchType=${encodeURIComponent(searchTypeValue)}`;  // Ensure searchType is correctly appended to the URL
                
                window.location.href = url;  // Redirect with the correct parameters
            }
        });

        // Display results
        function displayResults(fetchedResults) {
            // Clear existing results
            resultsContainer.innerHTML = '';

            if (sourcesSection) {
                sourcesSection.style.display = '';
            }

            // Check if fetchedResults is valid and has data
            if (!fetchedResults || fetchedResults.length === 0) {
                // Display "No results" message if there are no matches
                resultsContainer.innerHTML = `
                    <div class="col-12 text-center mt-5">
                        <h2 class="text-light mb-5">Sorry, no results found. Please try again!</h2>
                    </div>`;
                return;
            }

            // Loop through the fetched results
            fetchedResults.forEach(result => {
                const imageUrl = result.image_url || 'images/default.jpg';
                const card = document.createElement('div');
                card.className = 'col-lg-3 col-md-4 col-sm-6 mb-4';

                // Check if the result exists and if it has a valid 'type'
                if (result && result.type) {
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
                                <h5 class="card-title mb-2 text-center text-warning">${result.type || 'Unknown'}</h5>
                                <p class="card-text mb-0 text-light"><strong>Year: </strong>${result.year || 'N/A'}</p>
                                <p class="card-text mb-0 text-light"><strong>IMDB_ID: </strong>${result.imdb_id || 'N/A'}</p>
                                <p class="card-text mb-0 text-light"><strong>TMDB_ID: </strong>${result.tmdb_id || 'N/A'}</p>
                                <button data-id="${result.id}" data-result-type="${result.result_type}" class="btn btn-success mt-auto view-details">View Details</button>
                            </div>
                        </div>`;
                    resultsContainer.appendChild(card);
                }
            });

            // Add event listeners for download and view details buttons
            document.querySelectorAll('.btn-download').forEach(button => {
                button.addEventListener('click', function () {
                    downloadJson(this.getAttribute('data-json'));
                });
            });

            // Add event listeners for view details buttons, handle dynamic redirection
            document.querySelectorAll('.view-details').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const resultType = this.getAttribute('data-result-type');

                    // Check the result type and redirect accordingly
                    if (resultType === 'person') {
                        window.location.href = `show.php?personId=${id}`;
                    } else {
                        window.location.href = `show.php?titleId=${id}`;
                    }
                });
            });
        }


        setTimeout(() => {
            const searchParams = new URLSearchParams(window.location.search);
            const searchQuery = searchParams.get('search');
            const searchTypeValue = searchParams.get('searchType');
            const yearQuery = searchParams.get('year');

            if (searchTypeValue) searchType.value = searchTypeValue;
            
            if ((searchQuery && searchQuery.trim() !== "") || (yearQuery && yearQuery.trim() !== "")) {
                if (searchQuery) searchInputMain.value = searchQuery;
                if (yearQuery) yearFilter.value = yearQuery;
                fetchResults();
            }
        }, 0);

        // Function to handle JSON download
        function downloadJson(data = null) {
            let dataToUse = detailsData;

            if (data) {
                dataToUse = JSON.parse(decodeURIComponent(data));
            }   
            if (typeof dataToUse !== 'undefined') {
                const blob = new Blob([JSON.stringify(dataToUse, null, 2)], { type: 'application/json' });
                const url = URL.createObjectURL(blob);
                const downloadLink = document.createElement('a');
                downloadLink.href = url;
                downloadLink.download = `${dataToUse.title || 'details'}_details.json`;
                downloadLink.click();
                URL.revokeObjectURL(url);
            } else {
                console.error("detailsData is not defined.");
            }
        }

        window.downloadJson = downloadJson;
    } else {
        console.error('Element with id "searchForm" not found in the DOM.');
    }
});
