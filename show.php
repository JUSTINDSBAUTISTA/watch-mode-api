<?php
define("API_KEY", "AnISQaWQOo81g1hfdRnHaUXsr2DGp5HIY4hzyNUW");

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
            background-image: url('<?php echo $details['backdrop']; ?>');
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
        <h1 class="display-4 text-center bg-dark bg-opacity-75 p-3 rounded"><?php echo htmlspecialchars($details['title']); ?> ( <?php echo htmlspecialchars($details['id']); ?> )</h1>
    </div>

    <div class="container-custom mt-5">
        <div class="row">
            <!-- Available On Section -->
            <div class="col-md-2">
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

            <!-- Main Content Section -->
            <div class="col-md-4" style="
                background-image: url('<?php echo $details['poster']; ?>');
                background-size: cover;
                background-position: center;
                height: 750px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            </div>

            <div class="col-md-5">
                <div class="p-3">
                    <h2><?php echo htmlspecialchars($details['title']); ?> <span class="badge bg-secondary"><?php echo htmlspecialchars($details['year']); ?></span></h2>
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
            <?php if (!empty($details['similar_titles'])): ?>
                <div class="col-md-1">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">
                            Similar Titles
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <?php foreach ($details['similar_titles'] as $similarId): ?>
                                    <li class="mb-1">
                                        <a href="show.php?watchmodeId=<?php echo $similarId; ?>" class="similar-title-link"><?php echo $similarId; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
