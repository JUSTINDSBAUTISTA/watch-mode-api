<?php if (!empty($titleDetails['similar_titles'])): ?>
    <div class="mt-4">
        <div class="h-100">
            <div class="card-body mb-5">
                <div class="card-header">
                    <h1 class="text-center text-light mb-4" style="font-size: 3em">Similar Titles</h1>
                </div>
                <div id="similarTitlesContainer" class="row row-cols-2 row-cols-md-3 row-cols-lg-6 row-cols-xl-6 row-cols-xxl-6 g-2 mx-0">
                    <?php foreach ($titleDetails['similar_titles'] as $similarId): 
                        $similarDetails = fetchDetailsByTitleId($similarId);
                        if ($similarDetails): ?>
                            <div class="col">
                                <a href="show.php?titleId=<?php echo htmlspecialchars($similarDetails['id']); ?>" class="text-decoration-none">
                                    <div class="card-custom text-center">
                                        <img async loading="lazy" src="<?php echo $similarDetails['posterLarge'] ?? 'images/background.jpg'; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($similarDetails['title']); ?>" style="height: 20vh; object-fit: cover;">
                                        <div class="card-body p-1">
                                            <h6 class="card-title text-truncate text-light" style="font-size: 1.35em;"><?php echo htmlspecialchars($similarDetails['title']); ?></h6>
                                            <h6 class="card-title text-truncate text-light" style="font-size: 1em;"><?php echo htmlspecialchars($similarDetails['release_date']); ?></h6>
                                            <hr class="hr my-0">
                                            <p class="card-text text-warning" style="font-size: 1.8em;"><small>ID: <?php echo htmlspecialchars($similarDetails['id']); ?></small></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif;
                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>