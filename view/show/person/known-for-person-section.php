<?php if (!empty($personDetails['known_for'])): ?>
    <div class="mt-4">
        <div class="h-100">
            <div class="card-body">
                <div class="card-header">
                    <h1 class="text-center text-light mb-4" style="font-size: 3em; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);">Known for</h1>
                </div>
                <div id="knownForContainer" class="row row-cols-2 row-cols-md-3 row-cols-lg-6 row-cols-xl-6 g-2 mx-0">
                    <?php foreach ($personDetails['known_for'] as $knownForId): ?>
                        <?php
                        // Fetch the details using the title ID (knownForId)
                        $knownDetails = fetchDetailsByTitleId($knownForId);
                        if ($knownDetails): ?>
                            <div class="col">
                                <a href="show.php?titleId=<?php echo htmlspecialchars($knownDetails['id']); ?>" class="text-decoration-none">
                                    <div class="card bg-dark text-light text-center">
                                        <img async loading="lazy" src="<?php echo $knownDetails['posterLarge'] ?? 'images/background.jpg'; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($knownDetails['title']); ?>" style="height: 280px; object-fit: cover;">
                                        <div class="card-body p-1">
                                            <h6 class="card-title text-truncate" style="font-size: 1.2em;"><?php echo htmlspecialchars($knownDetails['title']); ?></h6>
                                            <h6 class="card-title text-truncate text-light" style="font-size: 1em;"><?php echo htmlspecialchars($knownDetails['release_date'] ?? 'N/A'); ?></h6>
                                            <hr class="hr my-0">
                                            <p class="card-text text-warning" style="font-size: 1.8em;"><small>ID: <?php echo htmlspecialchars($knownDetails['id']); ?></small></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
