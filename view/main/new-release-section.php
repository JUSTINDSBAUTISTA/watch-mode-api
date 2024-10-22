<?php
// Calculate duration for scroll animation
$itemCount = count($newReleases);
$scrollDuration = $itemCount * .25; // 0.25s per item
?>

<!-- Display the New Releases Carousel if there are results -->
<?php if ($showNewReleases && !empty($newReleases)): ?>
    <div class="container mb-5">
        <h2 class="text-center text-warning">New Release!</h2>
        <p class="text-light text-center">" This endpoint will return release dates from the current date through the next 30 days. "</p>
        
        <!-- Apply dynamic animation duration -->
        <div class="new-releases-carousel overflow-hidden position-relative">
            <div class="scroll-container d-flex" style="animation-duration: <?php echo $scrollDuration; ?>s;">
                <?php foreach ($newReleases as $release): ?>
                    <a href="show.php?titleId=<?php echo htmlspecialchars($release['id']); ?>" class="release-card text-decoration-none mx-2" title="<?php echo htmlspecialchars($release['title']); ?>">
                        <div class="card bg-dark text-white">
                            <img src="<?php echo !empty($release['poster_url']) ? htmlspecialchars($release['poster_url']) : 'images/background.jpg'; ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($release['title']); ?>">
                            <div class="card-body d-flex flex-column justify-content-between p-2 text-center">
                                <h5 class="card-id text-warning mb-1" style="font-size: 1.25em;">
                                    ID: <?php echo htmlspecialchars($release['id']); ?>
                                </h5>
                                <hr class="hr my-1">
                                <h6 class="card-title text-light mb-1" style="font-size: 1em;">
                                    <?php echo htmlspecialchars($release['title']); ?>
                                </h6>
                                <p class="card-type text-secondary mt-auto mb-0" style="font-size: 0.9em;">
                                    <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($release['source_release_date']))); ?>
                                </p>
                                <p class="card-type text-secondary mb-0" style="font-size: 0.9em;">
                                    (Release date)
                                </p>
                                <p class="card-type text-secondary mt-auto mb-0" style="font-size: 0.9em;">
                                    <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($release['type']))); ?>
                                </p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
