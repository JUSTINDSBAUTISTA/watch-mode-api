<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchmode API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
    <link rel="stylesheet" href="css/index/styles.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Loading spinner styling */
        #loadingSpinner {
            display: none;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center mb-4 text-light">WATCHMODE API</h1>
        <form id="searchForm" class="mb-4 d-flex align-items-center">
            <button id="resetButton" class="btn btn-secondary me-3" type="button">Reset</button>
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Enter title keyword or Watchmode ID..." required>
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
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p>Loading results...</p>
        </div>
        
        <div class="results"></div>
        
        <!-- Search Results -->
        <div id="resultsContainer" class="row">
            <!-- Search results will be displayed here as responsive cards -->
        </div>

        <!-- Pagination Controls -->
        <div id="paginationControls" class="d-flex justify-content-center mt-4">
            <!-- Pagination buttons will be dynamically added here by JavaScript -->
        </div>
    </div>
    
    <script src="javascript/main.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
</body>
</html>
