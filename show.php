<?php
require_once 'loadenv.php'; // Load environment variables

// Use the API key from .env
define("API_KEY", $_ENV['WATCHMODE_API_KEY']);

function fetchDetailsByWatchmodeId($watchmodeId) {
    $url = "https://api.watchmode.com/v1/title/$watchmodeId/details/?apiKey=" . API_KEY . "&append_to_response=sources";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$watchmodeId = $_GET['watchmodeId'] ?? null;
if ($watchmodeId) {
    $details = fetchDetailsByWatchmodeId($watchmodeId);
} else {
    echo "No Watchmode ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($details['title'] ?? 'Title Details'); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .backdrop {
            position: relative;
            background-image: url('<?php echo !empty($details['backdrop']) ? $details['backdrop'] : 'default.jpg'; ?>');
            background-size: cover;
            background-position: center;
            height: 300px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container-custom {
            margin-left: 2%;
            margin-right: 2%;
        }
        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: black;
            font-weight: bold;
            text-decoration: none;
            background-color: grey;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .similar-title-link {
            color: black;
            text-decoration: none;
            font-weight: bold;
        }
        .similar-title-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <!-- Backdrop Banner -->
    <div class="backdrop d-flex justify-content-center">
        <a href="index.php" class="back-to-home">Back to Home</a>
        <h1 class="display-4 text-center bg-dark bg-opacity-75 p-3 rounded"><?php echo htmlspecialchars($details['title']); ?> ( <?php echo htmlspecialchars($details['id']); ?> )</h1>
    </div>

    <div class="container-custom mt-3">
        <div class="row">
            <!-- Available On Section -->
            <?php if (!empty($details['sources'])): ?>
                <div class="col-12 col-md-3 col-lg-3 col-xl-2">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            Available On
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <?php foreach ($details['sources'] as $source): ?>
                                    <li class="mb-2">
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
            <?php else: ?>
                <div class="col-12 col-md-3 col-lg-3 col-xl-2">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            Available On
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Not available on any platform</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Main Content Section -->
            <div class="col-12 col-md-4 col-lg-4 col-xl-4" style="
                background-image: url('<?php echo !empty($details['poster']) ? $details['poster'] : 'default.jpg'; ?>');
                background-size: cover;
                background-position: center;
                height: 750px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            </div>

            <div class="col-12 col-md-5 col-lg-5 col-xl-5">
                <div class="p-3">
                    <h2>
                        <?php echo htmlspecialchars($details['title']); ?>
                        <?php echo !empty($details['year']) ? '<span class="badge bg-secondary">' . htmlspecialchars($details['year']) . '</span>' : ''; ?>
                    </h2>
                    <p class="lead"><?php echo htmlspecialchars($details['plot_overview']); ?></p>
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

            <!-- Similar Titles Section -->
        </div>
        <?php if (!empty($details['similar_titles'])): ?>
<!-- Similar Titles Section -->
            <div class="mt-4">
                <div class="card h-100">
                    <div class="card-header bg-info text-white text-center">
                        Similar Titles
                    </div>
                    <div class="card-body">
                        <!-- Loading Spinner -->
                        <div id="loadingSpinner" class="text-center my-3">
                            <div class="spinner-border text-info" role="status">
                                <span class="sr-only">Loading similar titles...</span>
                            </div>
                            <p>Loading similar titles...</p>
                        </div>

                        <!-- Similar Titles Container -->
                        <div id="similarTitlesContainer" class="d-flex flex-wrap justify-content-center" style="display: none;">
                            <?php foreach ($details['similar_titles'] as $similarId): 
                                $similarDetails = fetchDetailsByWatchmodeId($similarId); // Fetch details for each similar title
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
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingSpinner = document.getElementById('loadingSpinner');
            const similarTitlesContainer = document.getElementById('similarTitlesContainer');

            // Simulate fetching similar titles
            setTimeout(() => {
                // Hide loading spinner and show similar titles
                loadingSpinner.style.display = 'none';
                similarTitlesContainer.style.display = 'flex';
            }, 1500); // Adjust this timeout as necessary for your actual loading time
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
