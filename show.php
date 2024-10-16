<?php
require_once 'functions.php'; // Include reusable functions

// GO TO functions.php
$watchmodeId = isset($_GET['watchmodeId']) && ctype_digit($_GET['watchmodeId']) ? $_GET['watchmodeId'] : null;
$details = $watchmodeId ? fetchDetailsByWatchmodeId($watchmodeId) : null;
$castCrew = fetchCastAndCrewByWatchmodeId($watchmodeId);
$genreClasses = getGenreClass($genreName);

?>

<!DOCTYPE html>
<html lang="en">
    <!-- Head Section -->
     <?php require 'view/layouts/header.php'; ?>
<body>
    <!-- Loading Overlay -->
    <div id="loadingOverlay">
        <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Navbar Section -->
     <?php require 'view/show/navbar.php'; ?>

    <!-- Backdrop Section with Title and ID -->
    <?php require 'view/show/backdrop-section.php'; ?>

    <!-- Main Content Section -->
    <?php require 'view/show/main-show.php'; ?>

    <!-- Footer Section -->
     <?php require 'view/layouts/footer.php'; ?>
</body>
</html>
