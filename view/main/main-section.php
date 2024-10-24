<main class="container mt-0 mb-5">
    <h1 class="text-center my-4 text-light">
        WATCHMODE<span class="text-warning">API</span><i class="text-warning fas fa-video"></i>
    </h1>

    <!-- Search Form -->
    <?php require 'view/main/form.php'; ?>
    
    
    <!-- Sort buttons -->
    <div id="sortButtons" class="mb-3 d-flex gap-2 d-none">
        <button class="btn btn-dark" id="sortName" data-order="asc">Sort by Name (A-Z)</button>
        <button class="btn btn-dark" id="sortYear" data-order="asc">Sort by Year (Latest-Oldest)</button>
    </div>
    
    <div id="loadingSpinner" class="my-4">
        <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p>Loading results 👓</p>
    </div>
    
    <div id="resultsContainer" class="row">
        <!-- Search results will be displayed here as responsive cards -->
    </div>
    
    <!-- Pagination Controls -->
    <div id="paginationControls" class="d-flex justify-content-center mt-4">
        <!-- Pagination buttons will be dynamically added here by JavaScript -->
    </div>
    
    <!-- New Releases Section -->
    <?php require 'view/main/new-release-section.php'; ?>
    
    <!-- Title Release Dates Section -->
    <?php require 'view/main/title-release-dates-section.php'; ?>
    
    <!-- Sources Section -->
    <?php /* require 'view/main/sources-section.php'; */?>
    
    <!-- Worldwide Flags Section -->
    <?php require 'view/main/flags-section.php'; ?>
    
</main>
