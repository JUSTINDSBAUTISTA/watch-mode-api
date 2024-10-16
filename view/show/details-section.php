<div class="show-details bg-light col-12 col-md-12 col-lg-4 rounded">
    <div class="p-3">
        <h4 class="text-success">
            <?php echo htmlspecialchars($details['title'] ?? 'Not available'); ?> 
            <?php echo !empty($details['year']) ? '<span class="bg-warning-subtle">' . htmlspecialchars($details['year']) . '</span>' : ''; ?>
        </h4>

        <hr class="hr">
        
        <!-- Plot Overview -->
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
        
        <!-- Critic Score -->
        <p><strong>Critic Score:</strong> 
            <?php 
                echo isset($details['critic_score']) 
                    ? htmlspecialchars($details['critic_score']) . '%' 
                    : 'Not available'; 
            ?>
        </p>

        <!-- Runtime -->
        <p><strong>Runtime:</strong> 
            <?php 
                echo isset($details['runtime_minutes']) 
                    ? htmlspecialchars($details['runtime_minutes']) . ' minutes <i class="far fa-clock"></i>' 
                    : 'Not available'; 
            ?> 
        </p>
        
        <!-- TV Rating -->
        <p><strong>TV Rating:</strong> 
            <?php 
                echo !empty($details['us_rating']) 
                    ? htmlspecialchars($details['us_rating'])
                    : 'Not available'; 
            ?>
        </p>
        
        <!-- Language -->
        <p><strong>Language:</strong> 
            <?php 
                echo !empty($details['original_language']) 
                    ? htmlspecialchars(strtoupper($details['original_language'])) 
                    : 'Not available'; 
            ?>
        </p>

        <!-- Trailer Button -->
        <?php if (!empty($details['trailer'])): ?>
            <a href="<?php echo htmlspecialchars($details['trailer']); ?>" target="_blank" class="btn btn-danger mt-3">Watch Trailer</a>
        <?php else: ?>
            <p class="text-muted mt-3">Trailer not available</p>
        <?php endif; ?>
    </div>
</div>
