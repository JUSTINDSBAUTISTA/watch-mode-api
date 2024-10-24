<?php
require_once 'functions.php'; // Include reusable functions

// Check if there’s a search query or year filter
$searchQuery = isset($_GET['search']) ? $_GET['search'] : null;
$yearQuery = isset($_GET['year']) ? $_GET['year'] : null;
$region = isset($_GET['region']) ? $_GET['region'] : 'US'; // Default to 'US' if no region is provided
$showNewReleases = empty($searchQuery) && empty($yearQuery);

// Set startDate and endDate for fetching releases
$startDate = date('Ymd'); // Current date in the format YYYYMMDD
$endDate = date('Ymd', strtotime('+30 days')); // 30 days from current date

// Fetch new releases only if there’s no search
$newReleases = $showNewReleases ? fetchNewReleases($startDate, $endDate) : [];

// Fetch sources regions
$sources_by_type = fetchSources([], $region); 

// Fetch flags data
$flags = fetchFlags(); // Fetch flags data

// Fetch Title Release Dates for the selected region
$titleReleaseDates = fetchTitleReleaseDates();

?>
<!DOCTYPE html>
<html lang="en">
    <?php require 'view/layouts/header.php'; ?>
<body>


    <!-- Main Section -->
    <?php require 'view/main/main-section.php'; ?>

    <!-- Footer Section -->
    <?php require 'view/layouts/footer.php'; ?>

    <!-- JavaScript for Main Page -->
    <script src="javascript/main.js" ></script>
    <script src="javascript/main/flag_slide.js" ></script>
    <script src="javascript/main/new_release.js" ></script>
    <script src="javascript/main/source_carousels.js" ></script>
</body>
</html>
