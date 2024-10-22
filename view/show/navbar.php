<!-- Navbar Section -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top py-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/watchmode/">WATCHMODE<span class="text-warning">API</span><i class="text-warning fas fa-video"></i></a>
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
                    <!-- Radio buttons for search type -->
                    <div class="ms-3 d-flex justify-content-center align-items-center">
                        <!-- Radio button for title -->
                        <div class="form-check form-check-inline d-flex align-items-center">
                            <input type="radio" id="titleSearch" name="searchType" value="title" class="form-check-input" checked>
                            <label for="titleSearch" class="form-check-label text-light me-3">Title id</label>
                        </div>

                        <!-- Radio button for person -->
                        <div class="form-check form-check-inline d-flex align-items-center">
                            <input type="radio" id="personSearch" name="searchType" value="person" class="form-check-input">
                            <label for="personSearch" class="form-check-label text-light">Person id</label>
                        </div>
                    </div>

                    <button class="btn btn-outline-light ms-2" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>
</nav>
