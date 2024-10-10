<?php
    require_once 'functions.php'; // Include reusable functions
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
            WATCHMODE<span class="text-warning">API</span>
        </h1>
        <form id="searchForm" class="mb-4 d-flex align-items-center" role="search">
            <button id="resetButton" class="btn btn-secondary me-3" type="button">Reset</button>
            <div class="input-group">
                <input 
                    type="text" 
                    id="searchInput" 
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
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        <!-- Loading Spinner -->
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
    </div>

    <!-- Footer Section -->
    <?php require 'view/layouts/footer.php'; ?>
    
</body>
</html>
