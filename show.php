<?php
require_once 'functions.php'; // Include reusable functions

// Validate the provided watchmodeId
$watchmodeId = isset($_GET['watchmodeId']) && ctype_digit($_GET['watchmodeId']) ? $_GET['watchmodeId'] : null;
$details = $watchmodeId ? fetchDetailsByWatchmodeId($watchmodeId) : null;
$castCrew = fetchCastAndCrewByWatchmodeId($watchmodeId);

?>

<?php 
require_once 'show/genres.php'; // Include genre classes
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($details['title'] ?? 'Title Details'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/show/styles.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/show/genre.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    
    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">WATCHMODE-API</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Search Form in Navbar -->
                <form class="d-flex mx-auto w-75" id="searchForm" role="search">
                    <input 
                        class="form-control me-2" 
                        type="text" 
                        id="searchInput" 
                        placeholder="Search by Title" 
                        aria-label="Search" 
                        style="width: 100%;"
                    >
                    <div id="suggestions" class="suggestions d-none"></div>
                </form>
            </div>
        </div>
    </nav>

    <!-- Backdrop Section with Title and ID -->
    <?php if ($details): ?>
        <div class="backdrop d-flex justify-content-center align-items-center text-center position-relative" style="background-image: linear-gradient(to top, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)), url('<?php echo !empty($details['backdrop']) ? htmlspecialchars($details['backdrop']) : 'default.jpg'; ?>'); background-size: cover; background-position: center;">
            
            <!-- Overlay for Background Opacity -->
            <div class="position-absolute w-100 h-100" style="background-color: rgba(0, 0, 0, 0); top: 0; left: 0;"></div>
            
            <!-- Content on top of the overlay -->
            <h1 class="text-warning position-relative" style="font-size: 5em; text-shadow: 5px 3px 2px black">
                <?php echo htmlspecialchars($details['title']); ?> 
                <br>
                <span class="text-light">
                    id#<?php echo htmlspecialchars($details['id']); ?>
                    <!-- Download Icon with onclick to trigger download -->
                    <i class="fas fa-download ms-2" style="cursor: pointer;" onclick="downloadJson()"></i>
                </span>
            </h1>
        </div>
    <?php endif; ?>

    <div class="container" id="detailsContainer">
        <?php if ($details): ?>
            <div class="row g-3">               
                <!-- Poster Image Section -->
                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="poster-image" style="background-image: url('<?php echo !empty($details['poster']) ? htmlspecialchars($details['poster']) : 'default.jpg'; ?>'); background-size: cover; background-position: center; height: 100%; min-height: 300px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        </div>
                    </div>
                    
                    <!-- Details Section -->
                    <div class="bg-light col-12 col-md-12 col-lg-4">
                        <div class="p-3">
                            <h4 class="text-success">
                                <?php echo htmlspecialchars($details['title'] ?? 'Not available'); ?> 
                                <?php echo !empty($details['year']) ? '<span class="bg-warning-subtle">' . htmlspecialchars($details['year']) . '</span>' : ''; ?>
                            </h4>
                            <hr class="hr">
                            
                            <p class="lead">
                                <?php echo !empty($details['plot_overview']) ? htmlspecialchars($details['plot_overview']) : 'Plot overview not available'; ?>
                            </p>
                            <hr class="hr">
                            
                            <!-- Genres -->
                            <p><strong>Genres:</strong> 
                            <?php 
                            if (!empty($details['genre_names'])) {
                                foreach ($details['genre_names'] as $genre) {
                                    $class = getGenreClass($genre);
                                    echo '<span class="badge ' . $class . '">' . htmlspecialchars($genre) . '</span> ';
                                }
                            } else {
                                echo 'Not available';
                            }
                            ?>
                        </p>
                        
                        <!-- User Rating -->
                        <p class="mb-0"><strong>User Rating:</strong> 
                        <?php 
                                $userRating = isset($details['user_rating']) ? $details['user_rating'] : null;
                                echo $userRating ? htmlspecialchars($userRating) . ' / 10' : 'Not available'; 
                            ?>
                        </p>
                        
                        <!-- Star Rating Display -->
                        <div class="rating mb-2 text-warning">
                            <?php
                                if ($userRating) {
                                    $fullStars = floor($userRating);
                                    $halfStar = ($userRating - $fullStars) >= 0.5 ? 1 : 0;
                                    $emptyStars = 10 - ($fullStars + $halfStar);

                                    // Display full stars
                                    for ($i = 0; $i < $fullStars; $i++) {
                                        echo '<i class="fas fa-star"></i>';
                                    }

                                    // Display half star if applicable
                                    if ($halfStar) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    }

                                    // Display empty stars
                                    for ($i = 0; $i < $emptyStars; $i++) {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                } else {
                                    echo 'No rating available';
                                }
                            ?>
                        </div>
                        
                        <p><strong>Critic Score:</strong> 
                        <?php echo isset($details['critic_score']) ? htmlspecialchars($details['critic_score']) . '%' : 'Not available'; ?>
                    </p>
                    
                    <p><strong>Runtime:</strong> 
                    <?php 
                                echo isset($details['runtime_minutes']) 
                                    ? htmlspecialchars($details['runtime_minutes']) . ' minutes <i class="far fa-clock"></i>' 
                                    : 'Not available'; 
                            ?> 
                        </p>
                        
                        <p><strong>TV Rating:</strong> 
                        <?php 
                                echo !empty($details['us_rating']) 
                                    ? htmlspecialchars($details['us_rating'])
                                    : 'Not available'; ?>
                        </p>
                        
                        <p><strong>Language:</strong> 
                            <?php echo !empty($details['original_language']) ? htmlspecialchars(strtoupper($details['original_language'])) : 'Not available'; ?>
                        </p>

                        <!-- Trailer Button -->
                        <?php if (!empty($details['trailer'])): ?>
                            <a href="<?php echo htmlspecialchars($details['trailer']); ?>" target="_blank" class="btn btn-danger mt-3">Watch Trailer</a>
                        <?php else: ?>
                            <p class="text-muted mt-3">Trailer not available</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Available On Section with Scroll -->
                <div class="col-12 col-sm-12 col-md-12 col-lg-2">
                    <div class="row">
                        <!-- Streaming Sources (Scrollable) -->
                        <div class="col-12 mb-3">
                            <div class="card h-100">
                                <div class="card-header bg-info text-white">Available On</div>
                                <div class="card-body p-0" id="availableOnContainer" style="max-height: 250px; overflow-y: auto;">
                                    <ul class="list-unstyled mb-0">
                                        <?php foreach ($details['sources'] as $source): ?>
                                            <li class="p-2">
                                                <a href="<?php echo htmlspecialchars($source['web_url']); ?>" target="_blank" class="text-decoration-none">
                                                    <?php echo htmlspecialchars($source['name']); ?>
                                                </a>
                                                <span class="text-muted">(<?php echo htmlspecialchars($source['format']); ?>, <?php echo htmlspecialchars($source['type']); ?>, <?php echo htmlspecialchars($source['region']); ?>)</span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Cast Names (Scrollable) -->
                        <div class="col-12">
                            <div class="card h-100">
                                <div class="card-header bg-secondary text-white">Cast & Crew</div>
                                <div class="card-body p-0" id="castCrewContainer" style="max-height: 250px; overflow-y: auto;">
                                    <ul class="list-unstyled mb-0">
                                        <?php if (!empty($castCrew)): ?>
                                            <?php foreach ($castCrew as $person): ?>
                                                <li class="p-2">
                                                    <a href="<?php echo htmlspecialchars($person['headshot_url']); ?>" target="_blank" class="text-decoration-none">
                                                        <?php echo htmlspecialchars($person['full_name']); ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="p-2 text-muted">Cast & Crew information not available</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Similar Titles Section -->
            <?php if (!empty($details['similar_titles'])): ?>
                <div class="mt-4">
                    <div class="h-100">
                        <div class="card-body">
                            <div class="card-header">
                                <h1 class="text-center text-light mb-4" style="font-size: 3em">Similar Titles</h1>
                            </div>
                            <div id="similarTitlesContainer" class="row row-cols-2 row-cols-md-6 row-cols-lg-12 g-2 mx-0">
                                <?php foreach ($details['similar_titles'] as $similarId): 
                                    $similarDetails = fetchDetailsByWatchmodeId($similarId);
                                    if ($similarDetails): ?>
                                        <div class="col">
                                            <a href="show.php?watchmodeId=<?php echo htmlspecialchars($similarDetails['id']); ?>" class="text-decoration-none">
                                                <div class="card card-custom text-center">
                                                    <img src="<?php echo $similarDetails['poster'] ?? 'default.jpg'; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($similarDetails['title']); ?>" style="height: 100px; object-fit: cover;">
                                                    <div class="card-body p-1">
                                                        <h6 class="card-title text-truncate" style="font-size: 0.85em;"><?php echo htmlspecialchars($similarDetails['title']); ?></h6>
                                                        <p class="card-text" style="font-size: 0.8em;"><small>ID: <?php echo htmlspecialchars($similarDetails['id']); ?></small></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif;
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- Title Not Found Message -->
            <div class="alert alert-warning text-center mt-5">
                <h4>Title Not Found</h4>
                <p>The title you are looking for does not exist in our records. Please try a different title or ID.</p>
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
