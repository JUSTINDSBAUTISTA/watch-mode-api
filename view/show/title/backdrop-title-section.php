<!-- Backdrop Section -->
<?php if ($titleDetails): ?>
    <div class="backdrop d-flex justify-content-center align-items-center text-center position-relative" 
         style="background-image: linear-gradient(90deg, rgba(19,13,129,1) 0%, rgba(5,0,75,0.3) 50%, rgba(255,0,0,1) 100%), 
                url('<?php echo !empty($titleDetails['backdrop']) ? htmlspecialchars($titleDetails['backdrop']) : 'images/background.jpg'; ?>'); 
                background-size: cover; 
                background-position: center; 
                max-height: 300px; /* Adjust for mobile devices */">

        <!-- Overlay for Background Opacity -->
        <div class="position-absolute w-100 h-100" style="background-color: rgba(0, 0, 0, 0.4); top: 0; left: 0;"></div>
        
        <!-- Responsive Title Text -->
        <h1 class="text-warning position-relative title-responsive">
            <?php echo htmlspecialchars($titleDetails['title']); ?> 
            <br>
            <span class="text-light">
                id#<?php echo htmlspecialchars($titleDetails['id']); ?>
                <!-- Download Icon with onclick to trigger download -->
                <i class="fas fa-download ms-2 text-light" style="cursor: pointer;" onclick="downloadJson()"></i>
            </span>
        </h1>
    </div>
<?php endif; ?>
