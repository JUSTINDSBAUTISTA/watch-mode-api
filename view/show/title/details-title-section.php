<div class="show-details col-12 col-md-12 col-lg-4 rounded">
    <div class="p-3">
        <h2 class="text-light">
            <?php echo htmlspecialchars($titleDetails['title'] ?? 'Not available'); ?> 
            <?php echo !empty($titleDetails['year']) ? '<span>' . htmlspecialchars($titleDetails['year']) . '</span>' : ''; ?>
        </h2>

        <hr class="hr">
        
        <!-- Plot Overview -->
        <p class="lead">
            <?php echo !empty($titleDetails['plot_overview']) ? htmlspecialchars($titleDetails['plot_overview']) : 'Plot overview not available'; ?>
        </p>

        <hr class="hr">

        <!-- Genres -->
        <p><strong>Genres:</strong> 
            <?php 
                if (!empty($titleDetails['genre_names'])) {
                    foreach ($titleDetails['genre_names'] as $genre) {
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
                $userRating = isset($titleDetails['user_rating']) ? $titleDetails['user_rating'] : null;
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
        
        <!-- Critic Score -->
        <p><strong>Critic Score:</strong> 
            <?php 
                echo isset($titleDetails['critic_score']) 
                    ? htmlspecialchars($titleDetails['critic_score']) . '%' 
                    : 'Not available'; 
            ?>
        </p>

        <!-- Runtime -->
        <p><strong>Runtime:</strong> 
            <?php 
                echo isset($titleDetails['runtime_minutes']) 
                    ? htmlspecialchars($titleDetails['runtime_minutes']) . ' minutes <i class="far fa-clock"></i>' 
                    : 'Not available'; 
            ?> 
        </p>
        
        <!-- TV Rating -->
        <p><strong>TV Rating:</strong> 
            <?php 
                echo !empty($titleDetails['us_rating']) 
                    ? htmlspecialchars($titleDetails['us_rating'])
                    : 'Not available'; 
            ?>
        </p>
        
        <!-- Language -->
        <p><strong>Language:</strong> 
            <?php 
                echo !empty($titleDetails['original_language']) 
                    ? htmlspecialchars(strtoupper($titleDetails['original_language'])) 
                    : 'Not available'; 
            ?>
        </p>

        <?php if (!empty($titleDetails['trailer'])): ?>
            <?php
                // Parse the URL to get the video ID from the query parameter
                $trailerUrl = $titleDetails['trailer'];
                parse_str(parse_url($trailerUrl, PHP_URL_QUERY), $queryParams);
                $videoId = $queryParams['v'] ?? ''; // Get the 'v' parameter if it exists
            ?>
            <!-- Responsive YouTube Trailer Embed -->
            <?php if ($videoId): ?>
                <div class="embed-responsive">
                    <iframe 
                        src="https://www.youtube.com/embed/<?php echo htmlspecialchars($videoId); ?>" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            <?php else: ?>
                <p class="text-muted mt-3">Trailer link is invalid</p>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-muted mt-3">Trailer not available</p>
        <?php endif; ?>
        
    </div>
</div>
