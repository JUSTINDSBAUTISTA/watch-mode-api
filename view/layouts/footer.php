    <!-- Show Page Script -->
    <script>
        // Assign PHP JSON data to detailsData if available
        const detailsData = <?php echo json_encode($details, JSON_PRETTY_PRINT); ?>;
    </script>

    <!-- Scripts -->
    <script src="javascript/main.js"></script>
    <script src="javascript/show_page/show.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>