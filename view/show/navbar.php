<!-- Navbar Section -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top py-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/watch-mode-api/">WATCHMODE<span class="text-warning">API</span><i class="text-warning fas fa-video"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-lg-row-reverse" id="navbarNav">
            <!-- Search Form in Navbar -->
            <form id="searchFormHeader" class="d-flex align-items-center w-100" role="search" autocomplete="off">
            <div class="input-group">
                <input 
                    type="text" 
                    id="searchInputHeader" 
                    class="form-control" 
                    placeholder="Enter Title keyword or Watchmode ID" 
                    aria-label="Search" 
                    required
                >
                <div id="suggestions" class="suggestions d-none">
                    
                    <!-- Suggestions content will be dynamically added here -->
                </div>
                <button class="btn btn-outline-light" type="submit">Search</button>
            </div>
        </form>
        </div>
    </div>
</nav>
