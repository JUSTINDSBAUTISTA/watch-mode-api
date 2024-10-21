<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="person-details bg-secondary rounded text-center p-4" style="max-width: 800px; width: 100%; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);">
        <!-- Full Name -->
        <h2 class="text-warning mb-4" style="font-weight: bold;">
            <?php echo htmlspecialchars($personDetails['full_name'] ?? 'Not available'); ?>
        </h2>
        <hr class="hr bg-light mb-4">

        <div class="row text-start">
            <!-- First Column -->
            <div class="col-md-6 text-light">
                <!-- Date of Birth -->
                <p><strong>Date of Birth:</strong> 
                    <?php echo !empty($personDetails['date_of_birth']) 
                        ? htmlspecialchars($personDetails['date_of_birth']) 
                        : 'Not available'; 
                    ?>
                </p>

                <!-- Date of Death (if applicable) -->
                <?php if (!empty($personDetails['date_of_death'])): ?>
                    <p><strong>Date of Death:</strong> 
                        <?php echo htmlspecialchars($personDetails['date_of_death']); ?>
                    </p>
                <?php endif; ?>

                <!-- Place of Birth -->
                <p><strong>Place of Birth:</strong> 
                    <?php echo !empty($personDetails['place_of_birth']) 
                        ? htmlspecialchars($personDetails['place_of_birth']) 
                        : 'Not available'; 
                    ?>
                </p>

                <!-- Main Profession -->
                <p><strong>Main Profession:</strong> 
                    <?php echo !empty($personDetails['main_profession']) 
                        ? htmlspecialchars(ucfirst($personDetails['main_profession'])) 
                        : 'Not available'; 
                    ?>
                </p>

                <!-- Secondary Profession -->
                <p><strong>Secondary Profession:</strong> 
                    <?php echo !empty($personDetails['secondary_profession']) 
                        ? htmlspecialchars(ucfirst($personDetails['secondary_profession'])) 
                        : 'Not available'; 
                    ?>
                </p>

                <!-- Tertiary Profession -->
                <p><strong>Tertiary Profession:</strong> 
                    <?php echo !empty($personDetails['tertiary_profession']) 
                        ? htmlspecialchars(ucfirst($personDetails['tertiary_profession'])) 
                        : 'Not available'; 
                    ?>
                </p>
            </div>

            <!-- Second Column -->
            <div class="col-md-6 text-light">
                <!-- IMDb ID -->
                <p><strong>IMDb ID:</strong> 
                    <?php echo !empty($personDetails['imdb_id']) 
                        ? '(<a href="https://www.imdb.com/name/' . htmlspecialchars($personDetails['imdb_id']) . '" target="_blank" class="text-warning">' . htmlspecialchars($personDetails['imdb_id']) . '</a>)'
                        : 'Not available'; 
                    ?>
                </p>

                <!-- TMDb ID -->
                <p><strong>TMDb ID:</strong> 
                    <?php echo !empty($personDetails['tmdb_id']) 
                        ? '(<a href="https://www.themoviedb.org/person/' . htmlspecialchars($personDetails['tmdb_id']) . '" target="_blank" class="text-warning">' . htmlspecialchars($personDetails['tmdb_id']) . '</a>)'
                        : 'Not available'; 
                    ?>
                </p>

                <!-- Relevance Percentile -->
                <p><strong>Relevance:</strong> 
                    <?php echo isset($personDetails['relevance_percentile']) 
                        ? htmlspecialchars($personDetails['relevance_percentile']) . '%' 
                        : 'Not available'; 
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
