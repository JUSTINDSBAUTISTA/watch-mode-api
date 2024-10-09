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
    <!-- Navbar Section -->
     <?php require 'view/show/navbar.php'; ?>

    <!-- Backdrop Section with Title and ID -->
    <?php require 'view/show/backdrop-section.php'; ?>

    <div class="container" id="detailsContainer">
        <?php if ($details): ?>
            <div class="row g-3">               
                <!-- Poster Image Section -->
                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="poster-image" style="background-image: url('<?php echo !empty($details['poster']) ? htmlspecialchars($details['poster']) : 'default.jpg'; ?>'); background-size: cover; background-position: center; height: 100%; min-height: 300px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        </div>
                    </div>

                    <!-- Details Section -->
                    <?php require 'view/show/details-section.php'; ?>    
                       
                </div>

                <!-- Available On & Cast Section -->
                <?php require 'view/show/cast-&-available-section.php'; ?>

            </div>

            <!-- Similar Titles Section -->
            <?php require 'view/show/similar-titles-section.php'; ?>

        <?php else: ?>
            <!-- Title Not Found Message -->
            <div class="alert alert-warning text-center mt-5">
                <h4>Title Not Found</h4>
                <p>The title you are looking for does not exist in API. Please try a different title.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script src="javascript/show_page/show.js"></script>
    <script>
        // Assign PHP JSON data to detailsData if available
        const detailsData = <?php echo json_encode($details, JSON_PRETTY_PRINT); ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
