<!-- Sources Section -->
<div id="sourcesSection" class="carousel-container">
    <div class="sources-section mb-5">
        <?php foreach ($sources_by_type as $type => $sources): ?>
            <p class="text-warning my-3"><?php echo ucfirst($type); ?> Services</p>
            
            <div class="source-carousel-container overflow-hidden position-relative">
                <div class="source-scroll-container d-flex">
                    <?php foreach ($sources as $source): ?>
                        <div class="source-card mx-2 text-center">
                            <img src="<?php echo htmlspecialchars($source['logo_100px']); ?>" 
                                alt="<?php echo htmlspecialchars($source['name']); ?>" 
                                class="source-logo img-fluid rounded">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
