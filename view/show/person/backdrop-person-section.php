<!-- Backdrop Section -->
<?php if ($personDetails): ?>
    <div class="backdrop d-flex justify-content-center align-items-center text-center position-relative" 
         style="background-image: linear-gradient(to top, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)), 
                url('<?php echo !empty($personDetails['headshot_url']) ? htmlspecialchars($personDetails['headshot_url']) : 'images/default.jpg'; ?>'); 
                background-size: cover; 
                background-position: center; 
                max-height: 300px; /* Adjust for mobile devices */">

        <!-- Overlay for Background Opacity -->
        <div class="position-absolute w-100 h-100" style="background-color: rgba(0, 0, 0, 0.4); top: 0; left: 0;"></div>
        
        <!-- Responsive Name Text -->
        <h1 class="text-warning position-relative title-responsive">
            <?php echo htmlspecialchars($personDetails['full_name']); ?> 
            <br>
            <span class="text-light">
                id#<?php echo htmlspecialchars($personDetails['id']); ?>
                <!-- Download Icon with onclick to trigger download -->
                <i class="fas fa-download ms-2 text-light" style="cursor: pointer;" onclick="downloadJson()"></i>
            </span>
        </h1>
    </div>
<?php endif; ?>