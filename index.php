<?php
require_once 'functions.php'; // Include reusable functions

// Check if there’s a search query or year filter
$searchQuery = isset($_GET['search']) ? $_GET['search'] : null;
$yearQuery = isset($_GET['year']) ? $_GET['year'] : null;
$showNewReleases = empty($searchQuery) && empty($yearQuery);

// Set startDate and endDate for fetching releases
$startDate = date('Ymd'); // Current date in the format YYYYMMDD
$endDate = date('Ymd', strtotime('+30 days')); // 30 days from current date

// Fetch new releases only if there’s no search
$newReleases = $showNewReleases ? fetchNewReleases($startDate, $endDate) : [];

// Fetch sources regions
$sources_by_type = fetchSources([], 'US'); 

$flags = fetchFlags(); // Fetch flags data

?>
<!DOCTYPE html>
<html lang="en">
    <?php require 'view/layouts/header.php'; ?>
<body>

    <!-- Background Section -->
    <!-- <div class="main-background d-flex justify-content-center align-items-center" style="background-image: linear-gradient(to top, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)), url('images/background.jpg'); background-size: cover; background-position: center; height: 250px;">
    </div>   -->
        
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
