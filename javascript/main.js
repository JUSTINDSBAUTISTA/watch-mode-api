document.addEventListener('DOMContentLoaded', function () {
    const searchFormMain = document.getElementById('searchFormMain');
    if (searchFormMain) {
        const searchInputMain = document.getElementById('searchInputMain');
        const suggestions = document.getElementById('suggestions');
        const yearFilter = document.getElementById('yearFilter');
        const resultsContainer = document.getElementById('resultsContainer');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const paginationControls = document.getElementById('paginationControls');
        const resetButton = document.getElementById('resetButton');
        const sortButtons = document.getElementById('sortButtons');
        const sortTitleButton = document.getElementById('sortTitle');
        const sortYearButton = document.getElementById('sortYear');
        const sourcesSection = document.getElementById('sourcesSection');
        const carousels = document.querySelectorAll('.source-carousel-container');
        const flagItems = document.querySelectorAll('.flag-item');

        function slideInOnScroll() {
            const windowHeight = window.innerHeight;
            
            flagItems.forEach(flag => {
                const flagTop = flag.getBoundingClientRect().top;
                
                if (flagTop < windowHeight * 0.9) {
                    flag.classList.add('visible');
                }
            });
        }
    
        // Initial check in case items are already in view
        slideInOnScroll();
    
        // Event listener for scrolling
        window.addEventListener('scroll', slideInOnScroll);


        // Add event listener for form submission
        searchFormMain.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevents the default form submission
        });

        carousels.forEach(carousel => {
            const scrollContainer = carousel.querySelector('.source-scroll-container');
    
            // Calculate scroll speed based on item count
            const itemCount = scrollContainer.children.length;
            const scrollSpeed = itemCount <= 5 ? 50 : Math.max(30 - itemCount, 10);
    
            let scrollAmount = 0;
    
            function scrollItems() {
                scrollAmount += 1;
                if (scrollAmount >= scrollContainer.scrollWidth / 2) {
                    scrollAmount = 0; // Reset to start to make it seamless
                }
                scrollContainer.scrollLeft = scrollAmount;
            }
    
            // Start the interval-based scrolling
            setInterval(scrollItems, scrollSpeed);
        });

        function resetSearch() {
            searchInputMain.value = '';
            yearFilter.value = '';
            resultsContainer.innerHTML = '';
            paginationControls.innerHTML = '';
            sortButtons.classList.add('d-none');
            sourcesSection.style.display = 'none';
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
            if (sourcesSection) sourcesSection.style.display = 'none';
            
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
        
        // Form submission to reload the page with parameters or redirect if ID
        searchFormMain.addEventListener('submit', function (event) {
            event.preventDefault();
            
            const keyword = searchInputMain.value.trim();
            const year = yearFilter.value;

            if (/^\d+$/.test(keyword)) {
                // If the keyword is numeric, assume it's a Watchmode ID and redirect to show.php
                window.location.href = `show.php?watchmodeId=${keyword}`;
            } else {
                // Otherwise, build the URL with title and year search parameters
                let url = '?';
                if (keyword) url += `search=${encodeURIComponent(keyword)}`;
                if (year) url += `${keyword ? '&' : ''}year=${encodeURIComponent(year)}`;
                
                window.location.href = url;
            }
        });

        // Display results
        function displayResults(fetchedResults) {
            resultsContainer.innerHTML = '';

            if (sourcesSection) {
                sourcesSection.style.display = '';
            }

            if (fetchedResults.length === 0) {
                // Display "No results" message if there are no matches
                resultsContainer.innerHTML = `
                    <div class="col-12 text-center mt-5">
                        <h2 class="text-light">Sorry, please try again!</h2>
                    </div>`;
                return;
            }

            fetchedResults.forEach(result => {
                const imageUrl = result.posterLarge || 'images/default.jpg';
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

        if (searchInputMain && searchFormMain) {
            // Show suggestions when typing in the search input
            searchInputMain.addEventListener('input', function () {
                const query = searchInputMain.value.trim();
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

        } else {
            console.error("searchInputMain or searchFormMain not found in the DOM.");
        }

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

