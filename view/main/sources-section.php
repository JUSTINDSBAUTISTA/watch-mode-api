<!-- Sources Section -->
<section class="sources-section mb-5">
    <?php foreach ($sources_by_type as $type => $sources): ?>
        <h2 class="text-warning"><?php echo ucfirst($type); ?> Services</h2>
        
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
</section>