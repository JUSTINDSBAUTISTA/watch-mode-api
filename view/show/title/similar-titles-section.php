<?php if (!empty($titleDetails['similar_titles'])): ?>
    <div class="mt-4">
        <div class="h-100">
            <div class="card-body mb-5">
                <div>
                    <h1 class="text-center text-light mb-4" style="font-size: 3em">Similar Titles</h1>
                </div>
                <!-- Static container for Similar Titles -->
                <div class="similar-titles-carousel overflow-hidden position-relative">
                    <div id="similarTitlesContainer" class="scroll-container d-flex flex-wrap">
                        <?php foreach ($titleDetails['similar_titles'] as $similarId): 
                            $similarDetails = fetchDetailsByTitleId($similarId);
                            if ($similarDetails): ?>
                                <a href="show.php?titleId=<?php echo htmlspecialchars($similarDetails['id']); ?>"
                                   class="release-card text-decoration-none mx-2"
                                   title="<?php echo htmlspecialchars($similarDetails['title']); ?>">
                                    <div class="card bg-dark text-white mb">
                                        <img src="<?php echo $similarDetails['posterLarge'] ?? 'images/background.jpg'; ?>" 
                                             class="card-img-top" 
                                             alt="<?php echo htmlspecialchars($similarDetails['title']); ?>" 
                                             style="height: 20vh; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <p class="card-text text-warning mb-0" style="font-size: 1.35em;"><small>ID: <?php echo htmlspecialchars($similarDetails['id']); ?></small></p>
                                            <hr class="hr my-2">
                                            <h6 class="card-title text-truncate text-light mb-0" style="font-size: 1em;"><?php echo htmlspecialchars($similarDetails['title']); ?></h6>
                                            <h6 class="card-title text-truncate text-secondary" style="font-size: .75em;"><?php echo htmlspecialchars($similarDetails['release_date']); ?></h6>
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
