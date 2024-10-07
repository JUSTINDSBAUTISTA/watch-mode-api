document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const resultsContainer = document.getElementById('resultsContainer');

    document.getElementById('searchForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        const keyword = searchInput.value.trim();
        
        const response = await fetch(`api.php?title=${encodeURIComponent(keyword)}`);
        const results = await response.json();
        
        displayResults(results);
    });

    function displayResults(results) {
        resultsContainer.innerHTML = '';
        results.forEach(result => {
            const imageUrl = result.poster || 'default.jpg';
            const card = document.createElement('div');
            // Use Bootstrap's responsive column classes
            card.className = 'col-lg-3 col-md-4 col-sm-6 mb-4';

            card.innerHTML = `
                <div class="card h-100">
                    <img src="${imageUrl}" class="card-img-top" alt="${result.title}">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-id">ID: ${result.id}</h4>
                        <hr class="hr">
                        <h5 class="card-title">${result.title}</h5>
                        <p class="card-text plot-overview">${result.plot_overview || 'No description available.'}</p>
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
