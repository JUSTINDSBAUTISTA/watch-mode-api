<div class="available-cast col-12 col-sm-12 col-md-12 col-lg-2">
    <div class="row">
        <!-- Streaming Sources (Scrollable) -->
        <div class="col-6 col-sm-6 col-lg-12 mb-2">
            <div class="card-title">
                <div class="card-header text-white text-center">Available On</div>
                <div class="card-body p-0" id="availableOnContainer" style="max-height: 450px; overflow-y: auto;">
                    <ul class="list-unstyled mb-0">
                        <?php if (!empty($titleDetails['sources'])): ?>
                            <?php foreach ($titleDetails['sources'] as $source): ?>
                                <li class="p-2">
                                    <a href="<?php echo htmlspecialchars($source['web_url']); ?>" target="_blank" class="text-decoration-none available-on-link text-warning">
                                        <?php echo htmlspecialchars($source['name']); ?>
                                    </a>
                                    <br>
                                    <span class="text-light">(<?php echo htmlspecialchars($source['format']); ?>, <?php echo htmlspecialchars($source['type']); ?>, <?php echo htmlspecialchars($source['region']); ?>)</span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="p-2 text-light opacity-50">Sources are not available</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Cast Names (Scrollable) -->
        <div class="col-6 col-sm-6 col-lg-12 mb-auto">
            <div class="card-title">
                <div class="card-header text-white text-center">Cast & Crew</div>
                <div class="card-body p-0" id="castCrewContainer" style="max-height: 450px; overflow-y: auto;">
                    <ul class="list-unstyled mb-0">
                        <?php if (!empty($castCrew)): ?>
                            <?php foreach ($castCrew as $person): ?>
                                <li class="p-2">
                                    <a href="<?php echo htmlspecialchars($person['headshot_url']); ?>" target="_blank" class="text-decoration-none cast-link text-warning">
                                        <?php echo htmlspecialchars($person['full_name']); ?>
                                    </a>
                                        <br>
                                        <?php echo !empty($person['role']) ? '<span class="text-light">(' . htmlspecialchars($person['role']) . ')</span>' : ''; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="p-2 text-light opacity-50">Cast & Crew information not available</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>