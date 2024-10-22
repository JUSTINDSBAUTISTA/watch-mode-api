<?php
// Calculate the total number of releases
$totalReleases = count($newReleases);
$initialDisplayCount = 7; // Display only 10 items initially
?>

<!-- Display the New Releases Carousel if there are results -->
<?php if ($showNewReleases && !empty($newReleases)): ?>
    <div class="container mb-5">
        <h2 class="text-center text-warning">New Release!</h2>
        <p class="text-light text-center">" This endpoint will return release dates from the current date through the next 30 days. "</p>

        <!-- Static scrollable container -->
        <div class="new-releases-carousel overflow-hidden position-relative">
            <div class="scroll-container d-flex flex-wrap">
                <?php foreach ($newReleases as $index => $release): ?>
                    <a href="show.php?titleId=<?php echo htmlspecialchars($release['id']); ?>"
                       class="release-card text-decoration-none mx-2 <?php echo $index >= $initialDisplayCount ? 'd-none' : ''; ?>"
                       title="<?php echo htmlspecialchars($release['title']); ?>">
                        <div class="card bg-dark text-white mb">
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
            <!-- Expand All and Collapse buttons -->
            <?php if ($totalReleases > $initialDisplayCount): ?>
                <div class="text-center mt-3">
                    <button id="expandAll" class="btn btn-warning">Expand All</button>
                    <button id="collapseAll" class="btn btn-warning d-none">Collapse</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
