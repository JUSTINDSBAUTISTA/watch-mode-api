<div id="flagsSection" class="container mt-5">
    <h1 class="text-center text-warning mb-4">We are worldwide!</h1>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 row-cols-xl-8 g-3">
        <?php foreach ($flags as $flag): ?>
            <div class="col flag-item">
                <div class="card bg-dark text-light text-center">
                    <img src="<?php echo htmlspecialchars($flag['flag']); ?>" alt="<?php echo htmlspecialchars($flag['name']); ?>" class="flag-img img-fluid">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-0"><?php echo htmlspecialchars($flag['name']); ?></h6>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>