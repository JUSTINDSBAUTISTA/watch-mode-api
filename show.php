<?php
require_once 'functions.php'; // Include reusable functions

// GO TO functions.php
$titleId = isset($_GET['titleId']) && ctype_digit($_GET['titleId']) ? $_GET['titleId'] : null;
$details = $titleId ? fetchDetailsByWatchmodeId($titleId) : null;
$castCrew = fetchCastAndCrewByWatchmodeId($titleId);
$genreClasses = getGenreClass($genreName);

?>

<!DOCTYPE html>
<html lang="en">
    <!-- Head Section -->
     <?php require 'view/layouts/header.php'; ?>
    <script async src="javascript/show_page/show.js" ></script>
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

    <!-- JavaScript for Show Page -->

</body>
</html>
