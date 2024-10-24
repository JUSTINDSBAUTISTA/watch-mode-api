<div class="mb-3">
    <div class="text-white text-center mb-2"><h1 class="text-center text-light mb-4" style="font-size: 3em">Cast & Crews</h1></div>
    <div id="castCarousel" class="carousel slide p-0" style="max-height: 450px; overflow-y: auto;" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php if (!empty($castCrew)): ?>
                <?php foreach (array_chunk($castCrew, 6) as $index => $personChunk): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="d-flex justify-content-center">
                            <?php foreach ($personChunk as $person): ?>
                                <div class="p-3 text-center" style="position: relative;">
                                    <!-- Hover effect with a shadow -->
                                    <img src="<?php echo htmlspecialchars($person['headshot_url']); ?>" 
                                         alt="<?php echo htmlspecialchars($person['full_name']); ?>" 
                                         class="img-fluid rounded-circle shadow-lg"
                                         style="height: 120px; width: 120px; object-fit: cover; transition: transform 0.3s, box-shadow 0.3s;">
                                    <!-- Name Overlay -->
                                    <div style="position: absolute; margin-top: -40px; width: 100%; padding: 10px 0; border-radius: 0 0 50% 50%;">
                                        <p class="text-white mb-0" style="margin-right: 35px; font-size: 0.9rem; font-weight: 500;">
                                            <?php echo htmlspecialchars($person['full_name']); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Custom Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#castCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark p-3 rounded-circle" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#castCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark p-3 rounded-circle" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>