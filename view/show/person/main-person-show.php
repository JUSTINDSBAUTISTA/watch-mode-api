<main class="container" id="detailsContainer">
    <?php if ($personDetails): ?>

        <div class="row">               
            <!-- Details Section -->
            <?php require 'view/show/person/details-person-section.php'; ?>    

        </div>
        <!-- Known For Section -->
        <?php require 'view/show/person/known-for-person-section.php'; ?>

    <!-- Person Not Found Message -->
    <?php else: ?>
        <div class="alert alert-warning text-center mt-5">
            <h4>Person Not Found</h4>
            <p>The person you are looking for does not exist in the API. Please try a different person.</p>
        </div>
    <?php endif; ?>
</main>
