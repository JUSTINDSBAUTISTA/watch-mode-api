<div class="available-cast col-12 col-sm-12 col-md-12 col-lg-2">
    <div class="row">
        <!-- Streaming Sources (Scrollable) -->
        <div class="col-6 col-sm-6 col-lg-12 mb-2">
            <div class="card">
                <div class="card-header bg-info text-white">Available On</div>
                <div class="card-body p-0" id="availableOnContainer" style="max-height: 450px; overflow-y: auto;">
                    <ul class="list-unstyled mb-0">
                        <?php if (!empty($details['sources'])): ?>
                            <?php foreach ($details['sources'] as $source): ?>
                                <li class="p-2">
                                    <a href="<?php echo htmlspecialchars($source['web_url']); ?>" target="_blank" class="text-decoration-none available-on-link">
                                        <?php echo htmlspecialchars($source['name']); ?>
                                    </a>
                                    <br>
                                    <span class="text-muted">(<?php echo htmlspecialchars($source['format']); ?>, <?php echo htmlspecialchars($source['type']); ?>, <?php echo htmlspecialchars($source['region']); ?>)</span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="p-2 text-muted">Sources are not available</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Cast Names (Scrollable) -->
        <div class="col-6 col-sm-6 col-lg-12 mb-auto">
            <div class="card">
                <div class="card-header bg-secondary text-white">Cast & Crew</div>
                <div class="card-body p-0" id="castCrewContainer" style="max-height: 450px; overflow-y: auto;">
                    <ul class="list-unstyled mb-0">
                        <?php if (!empty($castCrew)): ?>
                            <?php foreach ($castCrew as $person): ?>
                                <li class="p-2">
                                    <a href="<?php echo htmlspecialchars($person['headshot_url']); ?>" target="_blank" class="text-decoration-none cast-link">
                                        <?php echo htmlspecialchars($person['full_name']); ?>
                                    </a>
                                        <br>
                                        <?php echo !empty($person['role']) ? '<span class="text-muted">(' . htmlspecialchars($person['role']) . ')</span>' : ''; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="p-2 text-muted">Cast & Crew information not available</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>