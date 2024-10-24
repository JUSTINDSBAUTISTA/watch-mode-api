<!-- Backdrop Section -->
<?php if ($titleDetails): ?>
    <div class="backdrop d-flex justify-content-center align-items-center text-center position-relative" 
         style="background-image: 
                linear-gradient(to top, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 2%, rgba(0,0,0,0) 80%), 
                url('<?php echo !empty($titleDetails['backdrop']) ? htmlspecialchars($titleDetails['backdrop']) : 'images/background.jpg'; ?>'); 
                background-size: cover; 
                background-position: center; 
                max-height: 300px; /* Adjust for mobile devices */">

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
    
    <!-- A gradient block  -->
    <div style="display: block; height: 150px; width: 100%;
        background: black;
        background: linear-gradient(to top, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 100%);
        margin-bottom: -150px;
        ">
    </div>
<?php endif; ?>
