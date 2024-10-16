<form id="searchForm" class="mb-4 row gx-2 gy-2 align-items-center" role="search" autocomplete="off">
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
                class="form-control" 
                placeholder="Enter Title keyword or Watchmode ID (Year is Optional)" 
                aria-label="Search" 
                required
            >
            <div id="suggestions" class="suggestions d-none">
                <!-- Suggestions content will be dynamically added here -->
            </div>

            <!-- Year Filter Dropdown -->
            <select id="yearFilter" class="form-select" style="max-width: 120px;">
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