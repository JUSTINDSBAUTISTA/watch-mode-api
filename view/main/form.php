<form id="searchFormMain" class="mb-4 row gx-2 gy-2 align-items-center" role="search" autocomplete="off" method="GET" action="your_search_endpoint.php">
    <!-- Reset Button - Moves to the bottom with full width on smaller screens -->
    <div class="col-12 col-md-auto order-3 order-md-1">
        <button id="resetButton" class="btn btn-secondary w-100" type="button">Reset</button>
    </div>

    <!-- Search Input and Suggestions - Full Width -->
    <div class="col-12 col-md order-1 order-md-2">
        <div class="input-group">
            <input 
                type="text" 
                id="searchInputMain" 
                name="keyword" 
                class="form-control" 
                placeholder="Enter Title keyword or Watchmode ID (Year is Optional)" 
                aria-label="Search" 
                required
            >
            <div id="suggestions" class="suggestions d-none">
                <!-- Suggestions content will be dynamically added here -->
            </div>

            <!-- Dropdown for Search Type -->
            <select id="searchType" name="searchType" class="form-select" style="max-width: 120px;">
                <option value="1">All (Titles & People)</option>
                <option value="2">Titles Only</option>
                <option value="3">Movies Only</option>
                <option value="4">TV Only</option>
                <option value="5">People Only</option>
            </select>
            
            <!-- Year Filter Dropdown -->
            <select id="yearFilter" name="year" class="form-select" style="max-width: 120px;">
                <option value="">Select Year</option>
                <?php for ($year = 1939; $year <= 2045; $year++): ?>
                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                <?php endfor; ?>
            </select>

            <!-- Search Button -->
            <button class="btn btn-outline-light" type="submit">Search</button>
        </div>
    </div>
</form>
