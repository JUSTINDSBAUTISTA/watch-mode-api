<?php if (!empty($details['similar_titles'])): ?>
    <div class="mt-4">
        <div class="h-100">
            <div class="card-body">
                <div class="card-header">
                    <h1 class="text-center text-light mb-4" style="font-size: 3em">Similar Titles</h1>
                </div>
                <div id="similarTitlesContainer" class="row row-cols-2 row-cols-md-3 row-cols-lg-6 row-cols-xl-6 row-cols-xxl-6 g-2 mx-0">
                    <?php foreach ($details['similar_titles'] as $similarId): 
                        $similarDetails = fetchDetailsByWatchmodeId($similarId);
                        if ($similarDetails): ?>
                            <div class="col">
                                <a href="show.php?watchmodeId=<?php echo htmlspecialchars($similarDetails['id']); ?>" class="text-decoration-none">
                                    <div class="card card-custom text-center">
                                        <img src="<?php echo $similarDetails['poster'] ?? 'default.jpg'; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($similarDetails['title']); ?>" style="height: 100%; object-fit: cover;">
                                        <div class="card-body p-1">
                                            <h6 class="card-title text-truncate" style="font-size: 1.35em;"><?php echo htmlspecialchars($similarDetails['title']); ?></h6>
                                            <h6 class="card-title text-truncate text-muted" style="font-size: 1em;"><?php echo htmlspecialchars($similarDetails['release_date']); ?></h6>
                                            <hr class="hr my-0">
                                            <p class="card-text text-success" style="font-size: 1.8em;"><small>ID: <?php echo htmlspecialchars($similarDetails['id']); ?></small></p>
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