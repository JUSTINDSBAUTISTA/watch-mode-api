<?php
    require_once 'functions.php';

    // Check if there’s a search query or year filter
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : null;
    $yearQuery = isset($_GET['year']) ? $_GET['year'] : null;
    $showNewReleases = empty($searchQuery) && empty($yearQuery);

    // Fetch new releases only if there’s no search
    $newReleases = $showNewReleases ? fetchNewReleases() : [];
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Head Section -->
    <?php require 'view/layouts/header.php'; ?>
<body>
    <div class="backdrop d-flex justify-content-center align-items-center" style="background-image: linear-gradient(to top, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)), url('background.jpg'); background-size: cover; background-position: center; height: 250px;">
    </div>  

    <div class="container mt-0 mb-5">
        <h1 class="text-center mb-4 text-light">
            WATCHMODE<span class="text-warning">API</span><i class="text-warning fas fa-video"></i>
        </h1>
        <form id="searchForm" class="mb-4 d-flex align-items-center" role="search" autocomplete="off">
            <button id="resetButton" class="btn btn-secondary me-3" type="button">Reset</button>
            <div class="input-group">
                <input 
                    type="text" 
                    id="searchInputMain" 
                    class="form-control" 
                    placeholder="Enter title keyword or Watchmode ID... (Year is Optional)" 
                    aria-label="Search" 
                    required
                >
                <div id="suggestions" class="suggestions d-none">
                    <!-- Suggestions content will be dynamically added here -->
                </div>

                <select id="yearFilter" class="form-select" style="max-width: 120px;">
                    <option value="">Select Year</option>
                    <?php for ($year = 1939; $year <= 2045; $year++): ?>
                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                    <?php endfor; ?>
                </select>
                <button class="btn btn-outline-light" type="submit">Search</button>
            </div>
        </form>
        
        <!-- Sort buttons -->
        <div id="sortButtons" class="mb-3 d-flex gap-2 d-none">
            <button class="btn btn-dark" id="sortTitle" data-order="asc">Sort by Title (A-Z)</button>
            <button class="btn btn-dark" id="sortYear" data-order="asc">Sort by Year (Latest-Oldest)</button>
        </div>
                    
        <div id="loadingSpinner" class="my-4">
            <div class="spinner-border text-warning" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p>Loading results...</p>
        </div>

        <div id="resultsContainer" class="row">
            <!-- Search results will be displayed here as responsive cards -->
        </div>

        <!-- Pagination Controls -->
        <div id="paginationControls" class="d-flex justify-content-center mt-4">
            <!-- Pagination buttons will be dynamically added here by JavaScript -->
        </div>

        <!-- Display the New Releases Carousel if there are results -->
        <?php if ($showNewReleases && !empty($newReleases)): ?>
            <div class="container">
                <h2 class="text-center text-warning">New Releases</h2>
                <p class="text-light text-center">" This endpoint will return release dates from the current date through the next 30 days. "</p>
                <div class="new-releases-carousel overflow-hidden position-relative">
                    <div class="scroll-container d-flex">
                        <?php foreach ($newReleases as $release): ?>
                            <a href="show.php?watchmodeId=<?php echo htmlspecialchars($release['id']); ?>" class="release-card text-decoration-none mx-2" title="<?php echo htmlspecialchars($release['title']); ?>">
                                <div class="card bg-dark text-white">
                                    <img src="<?php echo htmlspecialchars($release['poster_url'] ?? 'default.jpg'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($release['title']); ?>">
                                    <div class="card-body d-flex flex-column justify-content-between p-2 text-center">
                                        <!-- ID with larger font size -->
                                        <h5 class="card-id text-warning mb-1" style="font-size: 1.25em;">
                                            ID: <?php echo htmlspecialchars($release['id']); ?>
                                        </h5>
                                        <!-- Horizontal line -->
                                        <hr class="hr my-1">
                                        <!-- Title -->
                                        <h6 class="card-title text-light mb-1" style="font-size: 1em;">
                                            <?php echo htmlspecialchars($release['title']); ?>
                                        </h6>
                                        <!-- Type fixed at the bottom -->
                                        <p class="card-type text-secondary mt-auto mb-0" style="font-size: 0.9em;">
                                            <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($release['type']))); ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Footer Section -->
    <?php require 'view/layouts/footer.php'; ?>
    
</body>
</html>
