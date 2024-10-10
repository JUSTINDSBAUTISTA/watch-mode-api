<!-- Navbar Section -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/watch-mode-api/">WATCHMODE-API</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Search Form in Navbar -->
            <form class="d-flex mx-auto w-75" id="searchForm" role="search">
                <input 
                    class="form-control me-2" 
                    type="text" 
                    id="searchInput" 
                    placeholder="Search by Title" 
                    aria-label="Search" 
                    style="width: 100%;"
                >
                <div id="suggestions" class="suggestions d-none"></div>
            </form>
        </div>
    </div>
</nav>
