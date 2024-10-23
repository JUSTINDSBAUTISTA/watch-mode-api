<?php if (!empty($personDetails['known_for'])): ?>
    <div class="mt-4">
        <div class="h-100">
            <div class="card-body mb-5">
                <div>
                    <h1 class="text-center text-light mb-4" style="font-size: 3em; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);">Known For</h1>
                </div>
                <!-- Static container for Known For -->
                <div class="similar-titles-carousel overflow-hidden position-relative">
                    <div id="knownForContainer" class="scroll-container d-flex flex-wrap">
                        <?php foreach ($personDetails['known_for'] as $knownForId): 
                            $knownDetails = fetchDetailsByTitleId($knownForId);
                            if ($knownDetails): ?>
                                <a href="show.php?titleId=<?php echo htmlspecialchars($knownDetails['id']); ?>"
                                   class="release-card text-decoration-none mx-2"
                                   title="<?php echo htmlspecialchars($knownDetails['title']); ?>">
                                    <div class="card bg-dark text-white mb">
                                        <img src="<?php echo $knownDetails['posterLarge'] ?? 'images/background.jpg'; ?>" 
                                             class="card-img-top" 
                                             alt="<?php echo htmlspecialchars($knownDetails['title']); ?>" 
                                             style="height: 20vh; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <p class="card-text text-warning mb-0" style="font-size: 1.35em;"><small>ID: <?php echo htmlspecialchars($knownDetails['id']); ?></small></p>
                                            <hr class="hr my-2">
                                            <h6 class="card-title text-truncate text-light mb-0" style="font-size: 1em;"><?php echo htmlspecialchars($knownDetails['title']); ?></h6>
                                            <h6 class="card-title text-truncate text-secondary" style="font-size: .75em;"><?php echo htmlspecialchars($knownDetails['release_date'] ?? 'N/A'); ?></h6>
                                        </div>
                                    </div>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
