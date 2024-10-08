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

    $decodedResponse = json_decode($response, true);

    // Check if the response indicates failure
    if (isset($decodedResponse['success']) && $decodedResponse['success'] === false) {
        return null; // Title not found, return null to indicate failure
    }

    return $decodedResponse;
}

$watchmodeId = $_GET['watchmodeId'] ?? null;
$details = $watchmodeId ? fetchDetailsByWatchmodeId($watchmodeId) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($details['title'] ?? 'Title Details'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
    <style>
        .backdrop {
            position: relative;
            background-image: url('<?php echo !empty($details['backdrop']) ? $details['backdrop'] : 'default.jpg'; ?>');
            background-size: cover;
            background-position: center;
            height: 750px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container-custom { margin: 2%; }
    </style>
</head>
<body class="bg-secondary bg-gradient">
    
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">WATCHMODE-API</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-custom mt-3" id="detailsContainer">
        <?php if ($details): ?>
            <!-- Backdrop Banner -->
            <div class="backdrop d-flex justify-content-center">
                <h1 class="display-4 text-center bg-dark bg-opacity-75 p-3 rounded"><?php echo htmlspecialchars($details['title']); ?> ( <?php echo htmlspecialchars($details['id']); ?> )</h1>
            </div>
            
            <div class="row mt-4">
                <div class="col-12 col-md-3 col-lg-2">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">Available On</div>
                        <div class="card-body p-0" id="availableOnContainer" style="max-height: 750px; overflow-y: auto;">
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
                <div class="col-12 col-md-4 col-lg-6" style="background-image: url('<?php echo !empty($details['poster']) ? $details['poster'] : 'default.jpg'; ?>'); background-size: cover; background-position: center; height: 800px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                </div>
                <div class="bg-light col-12 col-md-5 col-lg-4">
                    <div class="p-3">
                        <h2 class="text-success"><?php echo htmlspecialchars($details['title']); ?> <?php echo !empty($details['year']) ? '<span class="bg-warning-subtle">' . htmlspecialchars($details['year']) . '</span>' : ''; ?></h2>
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
            </div>
        <?php else: ?>
            <!-- Title Not Found Message -->
            <div class="alert alert-warning text-center mt-5">
                <h2>Title Not Found</h2>
                <p>The title you are looking for does not exist in our records. Please try a different title or ID.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
