<?php
require_once 'functions.php'; // Include the reusable functions

// Validate the provided watchmodeId
$watchmodeId = isset($_GET['watchmodeId']) && ctype_digit($_GET['watchmodeId']) ? $_GET['watchmodeId'] : null;
$details = $watchmodeId ? fetchDetailsByWatchmodeId($watchmodeId) : null;
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
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <!-- Brand Logo/Title -->
            <a class="navbar-brand fw-bold" href="index.php">WATCHMODE-API</a>

            <!-- Toggle button for smaller screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Center-aligned Search Form -->
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

    <!-- Backdrop Banner -->
    <?php if ($details): ?>
        <div class="backdrop d-flex justify-content-center align-items-center text-center" style="background-image: url('<?php echo !empty($details['backdrop']) ? htmlspecialchars($details['backdrop']) : 'default.jpg'; ?>');">
            <h1 class="display-4 bg-dark bg-opacity-75 p-3 rounded text-white"><?php echo htmlspecialchars($details['title']); ?> ( <?php echo htmlspecialchars($details['id']); ?> )</h1>
        </div>
    <?php endif; ?>

    <div class="container mt-3" id="detailsContainer">
        <?php if ($details): ?>
            <div class="row g-3">
                <!-- Available On Section -->
                <div class="col-12 col-sm-4 col-md-3 col-lg-3">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">Available On</div>
                        <div class="card-body p-0" id="availableOnContainer" style="max-height: 300px; overflow-y: auto;">
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

                <!-- Poster Section -->
                <div class="col-12 col-sm-8 col-md-9 col-lg-5">
                    <div class="poster-image" style="background-image: url('<?php echo !empty($details['poster']) ? htmlspecialchars($details['poster']) : 'default.jpg'; ?>'); background-size: cover; background-position: center; height: 100%; min-height: 300px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                    </div>
                </div>

                <!-- Details Section -->
                <div class="bg-light col-12 col-md-12 col-lg-4">
                    <div class="p-3">
                        <h4 class="text-success"><?php echo htmlspecialchars($details['title']); ?> <?php echo !empty($details['year']) ? '<span class="bg-warning-subtle">' . htmlspecialchars($details['year']) . '</span>' : ''; ?></h4>
                        <hr class="hr">
                        <p class="lead"><?php echo htmlspecialchars($details['plot_overview']); ?></p>
                        <hr class="hr">
                        <p><strong>Genres:</strong> <?php echo implode(", ", $details['genre_names']); ?></p>
                        <p><strong>User Rating:</strong> <?php echo htmlspecialchars($details['user_rating']); ?> / 10</p>
                        <p><strong>Critic Score:</strong> <?php echo htmlspecialchars($details['critic_score']); ?>%</p>
                        <p><strong>Runtime:</strong> <?php echo htmlspecialchars($details['runtime_minutes']); ?> minutes</p>
                        <p><strong>TV Rating:</strong> <?php echo htmlspecialchars($details['us_rating']); ?></p>
                        <p><strong>Language:</strong> <?php echo htmlspecialchars($details['original_language']); ?></p>
                        <?php if (isset($details['trailer'])): ?>
                            <a href="<?php echo htmlspecialchars($details['trailer']); ?>" target="_blank" class="btn btn-danger mt-3">Watch Trailer</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Similar Titles Section -->
            <?php if (!empty($details['similar_titles'])): ?>
                <div class="mt-4">
                    <div class="h-100">
                        <div class="card-header bg-warning text-white text-center">
                            Similar Titles
                        </div>
                        <div class="card-body">
                            <div id="similarTitlesContainer" class="d-flex flex-wrap justify-content-center">
                                <?php foreach ($details['similar_titles'] as $similarId): 
                                    $similarDetails = fetchDetailsByWatchmodeId($similarId);
                                    if ($similarDetails): ?>
                                        <a href="show.php?watchmodeId=<?php echo htmlspecialchars($similarDetails['id']); ?>" class="text-decoration-none mx-2 my-2" style="width: 120px;">
                                            <div class="card text-center">
                                                <img src="<?php echo $similarDetails['poster'] ?? 'default.jpg'; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($similarDetails['title']); ?>" style="height: 100px; object-fit: cover;">
                                                <div class="card-body p-1">
                                                    <h6 class="card-title text-truncate" style="font-size: 0.85em;"><?php echo htmlspecialchars($similarDetails['title']); ?></h6>
                                                    <p class="card-text" style="font-size: 0.8em;"><small>ID: <?php echo htmlspecialchars($similarDetails['id']); ?></small></p>
                                                </div>
                                            </div>
                                        </a>
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

    <script src="javascript/show_page/show.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
