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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
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
<body class="bg-secondary bg-gradient">
    
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold back-to-home" href="index.php">
                WATCHMODE-API
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <form class="d-flex ms-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search Titles" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- Backdrop Banner -->
    <div class="backdrop d-flex justify-content-center">
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

            <div class="bg-light col-12 col-md-5 col-lg-5 col-xl-5">
                <div class="p-3">
                    <h2 class="text-success">
                        <?php echo htmlspecialchars($details['title']); ?>
                        <?php echo !empty($details['year']) ? '<span class="bg-warning-subtle">' . htmlspecialchars($details['year']) . '</span>' : ''; ?>
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
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
</body>
</html>
