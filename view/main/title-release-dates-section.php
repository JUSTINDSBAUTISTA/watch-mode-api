<div class="title-release-dates">
    <h2 class="text-center text-warning mt-5 mb-4">Title Release Dates</h2>

    <?php 
    // Group titles by title_type
    $groupedTitles = [];
    foreach ($titleReleaseDates as $release) {
        $groupedTitles[$release['title_type']][] = $release;
    }
    ?>

    <!-- Loop through each group (based on title_type) -->
    <?php foreach ($groupedTitles as $titleType => $releases): ?>
        <div class="mb-5">
            <h3 class="text-light"><?php echo htmlspecialchars(ucfirst($titleType)); ?></h3>
            <div id="carousel-<?php echo htmlspecialchars($titleType); ?>" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                    $limitedReleases = array_slice($releases, 0, 14);
                    $totalReleases = count($releases);
                    ?>

                    <!-- Display in chunks of 7 for each row -->
                    <?php foreach (array_chunk($limitedReleases, 7) as $index => $releaseChunk): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="row">
                                <?php foreach ($releaseChunk as $release): ?>
                                    <div class="col-lg-1-7 col-md-4">
                                        <!-- Fetch the poster image for each release dynamically -->
                                        <?php 
                                            $image = fetchDetailsByTitleId($release['id'])['posterLarge'] ?? 'images/background.jpg'; 
                                        ?>
                                        <!-- Wrap card in an anchor tag linking to titleId -->
                                        <a href="show.php?titleId=<?php echo htmlspecialchars($release['id']); ?>" class="text-decoration-none" target="_blank">
                                            <div class="card-title-image bg-dark text-light mb-4">
                                                <!-- Use lazy loading for the images -->
                                                <img data-src="<?php echo htmlspecialchars($image); ?>" 
                                                     class="lazy card-title-image" 
                                                     alt="<?php echo htmlspecialchars($release['title']); ?>">
                                                <!-- Overlay to display on hover -->
                                                <div class="card-overlay">
                                                    <h5>ID: <?php echo htmlspecialchars($release['id']); ?></h5>
                                                    <p>Title: <?php echo htmlspecialchars($release['title']); ?></p>
                                                    <p>Type: <?php echo htmlspecialchars($release['title_type']); ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Add "See All" card if total releases exceed 14 -->
                    <?php if ($totalReleases > 15): ?>
                        <div class="carousel-item">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-lg-1-7 col-md-4">
                                    <div class="card-title-image bg-dark text-light text-center mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title">See All</h5>
                                            <p class="card-text">View all titles in this category</p>
                                            <a href="see-all.php?titleType=<?php echo urlencode($titleType); ?>" class="btn btn-warning">See All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Carousel controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo htmlspecialchars($titleType); ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo htmlspecialchars($titleType); ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>
