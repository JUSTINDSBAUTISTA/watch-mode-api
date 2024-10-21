<?php
require_once 'functions.php'; // Include reusable functions

// TITLE SECTION
$titleId = isset($_GET['titleId']) && ctype_digit($_GET['titleId']) ? $_GET['titleId'] : null;
$titleDetails = $titleId ? fetchDetailsByTitleId($titleId) : null;
$castCrew = fetchCastAndCrewByTitleId($titleId);

// PERSON SECTION
$personId = isset($_GET['personId']) && ctype_digit($_GET['personId']) ? $_GET['personId'] : null;
$personDetails = $personId ? fetchDetailByPersonId($personId) : null;

// Get genre classes
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

    <!------- THIS IS THE TITLE SECTION --------->
    <?php if(!empty($titleDetails)): ?>
        <?php require 'view/show/title/title.php'; ?>
    <?php endif; ?>
    <!-- ------------------------------------- -->
    

    <!------ THIS IS THE PERSON SECTION --------->
    <?php if(!empty($personDetails)): ?>
        <?php require 'view/show/person/person.php'; ?>
    <?php endif; ?>
    <!-- ------------------------------------- -->


    <!-- Footer Section -->
    <?php require 'view/layouts/footer.php'; ?>

</body>
</html>
