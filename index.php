<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title Search</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container my-3">
        <h1 class="text-center mb-4">Search Titles</h1>
        <form id="searchForm" class="mb-4">
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Enter title keyword..." required>

                <!-- Start Year Dropdown -->
                <select id="startYearFilter" class="custom-select" style="max-width: 120px;">
                    <option value="">Start Year</option>
                    <?php for ($year = 1939; $year <= 2045; $year++): ?>
                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                    <?php endfor; ?>
                </select>

                <!-- End Year Dropdown -->
                <select id="endYearFilter" class="custom-select" style="max-width: 120px;">
                    <option value="">End Year</option>
                    <?php for ($year = 1939; $year <= 2045; $year++): ?>
                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                    <?php endfor; ?>
                </select>

                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="my-4">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p>Loading results...</p>
        </div>
        
        <!-- Search Results -->
        <div id="resultsContainer" class="row">
            <!-- Search results will be displayed here as responsive cards -->
        </div>
    </div>
    
    <script src="main.js"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
